<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Professional;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // USER — start or open conversation with pro
    public function userIndex()
    {
        $conversations = Conversation::where('user_id', Auth::id())
            ->with(['professional', 'latestMessage'])
            ->latest('last_message_at')
            ->get();
        return view('messages.user-index', compact('conversations'));
    }

    public function userChat(Request $request, $proId)
    {
        $pro = Professional::findOrFail($proId);

        $conversation = Conversation::firstOrCreate(
            ['user_id' => Auth::id(), 'professional_id' => $proId],
            ['last_message_at' => now()]
        );

        // Mark pro messages as read
        Message::where('conversation_id', $conversation->id)
            ->where('sender_type', 'professional')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = $conversation->messages()->get();
        return view('messages.chat', compact('conversation', 'messages', 'pro'));
    }

    public function userSend(Request $request, $conversationId)
    {
        $request->validate(['body' => 'required|string|max:2000']);

        $conversation = Conversation::where('id', $conversationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_type'     => 'user',
            'sender_id'       => Auth::id(),
            'body'            => $request->body,
        ]);

        $conversation->update(['last_message_at' => now()]);

        // Notify pro
        $user = Auth::user();
        Notification::send('professional', $conversation->professional_id, 'new_message',
            'New message from ' . $user->name,
            $request->body,
            '/pro/messages/' . $conversation->id
        );

        return redirect()->back();
    }

    // PROFESSIONAL — inbox
    public function proIndex()
    {
        if (!session('pro_id')) return redirect('/pro/login');

        $conversations = Conversation::where('professional_id', session('pro_id'))
            ->with(['user', 'latestMessage'])
            ->latest('last_message_at')
            ->get();

        return view('messages.pro-index', compact('conversations'));
    }

    public function proChat($conversationId)
    {
        if (!session('pro_id')) return redirect('/pro/login');

        $conversation = Conversation::where('id', $conversationId)
            ->where('professional_id', session('pro_id'))
            ->firstOrFail();

        // Mark user messages as read
        Message::where('conversation_id', $conversation->id)
            ->where('sender_type', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = $conversation->messages()->get();
        $pro      = Professional::find(session('pro_id'));
        return view('messages.pro-chat', compact('conversation', 'messages', 'pro'));
    }

    public function proSend(Request $request, $conversationId)
    {
        if (!session('pro_id')) return redirect('/pro/login');
        $request->validate(['body' => 'required|string|max:2000']);

        $conversation = Conversation::where('id', $conversationId)
            ->where('professional_id', session('pro_id'))
            ->firstOrFail();

        $pro = Professional::find(session('pro_id'));

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_type'     => 'professional',
            'sender_id'       => session('pro_id'),
            'body'            => $request->body,
        ]);

        $conversation->update(['last_message_at' => now()]);

        // Notify user
        Notification::send('user', $conversation->user_id, 'new_message',
            'New message from ' . $pro->full_name,
            $request->body,
            '/messages/' . $conversation->id
        );

        return redirect()->back();
    }
}