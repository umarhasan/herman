<?php
namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Teacher conversation list view (teacherIndex route)
    public function teacherIndex()
    {
        $auth = Auth::id();

        // Group existing messages by counterpart user id
        $conversations = Message::with(['sender','receiver'])
            ->where('sender_id', $auth)
            ->orWhere('receiver_id', $auth)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function($msg) use ($auth) {
                return $msg->sender_id == $auth ? $msg->receiver_id : $msg->sender_id;
            });

        // Optionally, you can also load all students if you want to show everybody.
        // For now we return only conversations (as your current view expects).
        return view('chat.teacher.index', compact('conversations'));
    }

    // Fetch messages between auth user and $otherUserId. Returns JSON array.
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

        // Mark messages sent to auth by otherUser as read
        Message::where('sender_id', $otherUserId)
            ->where('receiver_id', $auth)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json($messages);
    }

    // Send message from auth to $otherUserId
    public function sendMessage(Request $request, $otherUserId)
    {
        $request->validate(['message' => 'required|string|max:2000']);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $otherUserId,
            'message' => $request->message,
            'is_read' => false,
        ]);

        // broadcast to the receiver's private channel
        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message->load('sender'));
    }

    // Return unread count of messages FROM $id TO auth user
    public function unreadCount($id)
    {
        $userId = Auth::id();
        $count = Message::where('receiver_id', $userId)
            ->where('sender_id', $id)
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    // Mark as read (set is_read=true for messages sent BY $id TO auth)
    public function markAsRead($id)
    {
        $userId = Auth::id();
        Message::where('receiver_id', $userId)
            ->where('sender_id', $id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['status' => 'ok']);
    }
}
