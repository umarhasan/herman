<?php
namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\MessageSent;

class ChatController extends Controller
{
    // Start or open a chat (route already present)
    public function start(User $partner)
    {
        $me = auth()->user();

        $chat = Chat::firstOrCreate([
            'teacher_id' => $me->hasRole('Teacher') ? $me->id : $partner->id,
            'student_id' => $me->hasRole('Student') ? $me->id : $partner->id,
        ]);

        // You can redirect to page that opens modal or return JSON
        return response()->json(['chat_id' => $chat->id]);
    }

    // Load messages between Student & Teacher
    public function messages($teacherId)
    {
        $studentId = auth()->id();
        $chat = Chat::where('teacher_id', $teacherId)
                    ->where('student_id', $studentId)
                    ->with(['messages.sender'])
                    ->first();

        if(!$chat) {
            return response()->json([]); // optionally send chat_id: null
        }

        $messages = $chat->messages()->orderBy('created_at')->with('sender')->get()->map(function($m) use ($chat) {
            return [
                'id' => $m->id,
                'chat_id' => $chat->id,
                'sender_id' => $m->sender_id,
                'message' => $m->message,
                'created_at' => $m->created_at->toDateTimeString(), // CHANGED
                'sender' => [
                    'id' => $m->sender->id,
                    'name' => $m->sender->name,
                ]
            ];
        });

        return response()->json($messages);
    }

    public function send(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'message' => 'required|string|max:5000',
        ]);

        $me = auth()->user();
        $teacher = User::findOrFail($request->teacher_id);

        $chat = Chat::firstOrCreate([
            'teacher_id' => $me->hasRole('Teacher') ? $me->id : $teacher->id,
            'student_id' => $me->hasRole('Student') ? $me->id : $teacher->id,
        ]);

        $msg = $chat->messages()->create([
            'sender_id' => $me->id,
            'message'   => $request->message,
        ]);

        event(new MessageSent($msg));

        return response()->json([
            'id' => $msg->id,
            'message' => $msg->message,
            'created_at' => $msg->created_at->toDateTimeString(), // CHANGED
            'sender_name' => $me->name,
            'chat_id' => $chat->id,
        ]);
    }

    // ✅ Teacher Panel - Student list
    public function teacherChatList()
    {
        $teacherId = auth()->id();
        $students = Chat::where('teacher_id', $teacherId)->with('student')->get()->groupBy('student_id');
        return view('chat.teacher.list', compact('students'));
    }

    // ✅ Teacher Panel - Load messages with selected student
    public function teacherMessages($studentId)
    {
        $teacherId = auth()->id();
        $chat = Chat::where('teacher_id', $teacherId)
                    ->where('student_id', $studentId)
                    ->with(['messages.sender'])
                    ->first();

        if(!$chat) {
            return response()->json([]);
        }

        $messages = $chat->messages()->orderBy('created_at')->with('sender')->get()->map(function($m) use ($chat) {
            return [
                'id' => $m->id,
                'chat_id' => $chat->id,
                'sender_id' => $m->sender_id,
                'message' => $m->message,
                'created_at' => $m->created_at->toDateTimeString(), // CHANGED
                'sender' => [
                    'id' => $m->sender->id,
                    'name' => $m->sender->name,
                ],
            ];
        });

        return response()->json($messages);
    }

    // ✅ Teacher send message
    public function teacherSend(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'message' => 'required|string|max:5000',
        ]);

        $teacherId = auth()->id();

        $chat = Chat::firstOrCreate([
            'teacher_id' => $teacherId,
            'student_id' => $request->student_id,
        ]);

        $msg = $chat->messages()->create([
            'sender_id' => $teacherId,
            'message'   => $request->message,
        ]);

        event(new MessageSent($msg));

        return response()->json([
            'message' => $msg->message,
            'created_at' => $msg->created_at->toDateTimeString(), // CHANGED
            'sender_name' => auth()->user()->name,
            'chat_id' => $chat->id,
        ]);
    }
}
