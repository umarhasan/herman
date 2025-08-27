<?php
// app/Http/Controllers/ChatController.php
namespace App\Http\Controllers;

use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // fetch messages between auth user and $otherUserId
    public function fetchMessages($otherUserId)
    {
        $auth = Auth::id();

        $messages = Message::with('sender')
            ->where(function($q) use ($auth, $otherUserId){
                $q->where('sender_id', $auth)->where('receiver_id', $otherUserId);
            })
            ->orWhere(function($q) use ($auth, $otherUserId){
                $q->where('sender_id', $otherUserId)->where('receiver_id', $auth);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    // send message from auth user to $otherUserId
    public function sendMessage(Request $request, $otherUserId)
    {
        $request->validate(['message' => 'required|string|max:2000']);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $otherUserId,
            'message' => $request->message,
        ]);

        // broadcast to the receiver's private channel
        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message->load('sender'));
    }

    // teacher view: list of conversations (grouped by user)
    public function index()
    {
        $auth = Auth::id();

        $conversations = Message::with(['sender', 'receiver'])
            ->where('sender_id', $auth)
            ->orWhere('receiver_id', $auth)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function($msg) use ($auth) {
                return $msg->sender_id == $auth ? $msg->receiver_id : $msg->sender_id;
            });

        return view('chat.teacher.index', compact('conversations'));
    }
}
