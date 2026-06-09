<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat — HomeFix Pro</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: #0A1628; color: #fff; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background: #060D1A; border-bottom: 1px solid #1E293B; padding: 0 20px; height: 60px; display: flex; align-items: center; gap: 14px; position: sticky; top: 0; }
        .back { color: #64748B; text-decoration: none; font-size: .85rem; }
        .avatar { width: 40px; height: 40px; border-radius: 50%; background: #2563EB; display: flex; align-items: center; justify-content: center; font-family: 'Syne', sans-serif; font-weight: 700; font-size: .85rem; overflow: hidden; flex-shrink: 0; }
        .avatar img { width: 100%; height: 100%; object-fit: cover; }
        .user-name { font-family: 'Syne', sans-serif; font-weight: 700; font-size: .95rem; }
        .user-email { font-size: .75rem; color: #64748B; }
        .chat-box { flex: 1; padding: 20px; display: flex; flex-direction: column; gap: 12px; overflow-y: auto; max-height: calc(100vh - 130px); }
        .msg-wrap { display: flex; }
        .msg-wrap.me { justify-content: flex-end; }
        .bubble { max-width: 65%; padding: 10px 14px; border-radius: 16px; font-size: .9rem; line-height: 1.55; }
        .bubble-them { background: #1E293B; border: 1px solid #334155; border-radius: 16px 16px 16px 4px; }
        .bubble-me   { background: #2563EB; color: #fff; border-radius: 16px 16px 4px 16px; }
        .msg-time { font-size: .7rem; color: #475569; margin-top: 4px; }
        .send-bar { background: #060D1A; border-top: 1px solid #1E293B; padding: 14px 20px; display: flex; gap: 10px; }
        .send-bar input { flex: 1; background: #1E293B; border: 1px solid #334155; border-radius: 30px; padding: 10px 18px; color: #fff; font-size: .9rem; font-family: 'DM Sans', sans-serif; outline: none; }
        .send-bar input:focus { border-color: #2563EB; }
        .send-bar input::placeholder { color: #475569; }
        .btn-send { background: #2563EB; color: #fff; border: none; border-radius: 30px; padding: 10px 24px; font-size: .88rem; font-weight: 600; cursor: pointer; font-family: 'DM Sans', sans-serif; }
        .btn-send:hover { background: #1D4ED8; }
        .empty { text-align: center; color: #475569; padding: 40px; font-size: .88rem; flex: 1; display: flex; align-items: center; justify-content: center; }
    </style>
</head>
<body>

<div class="topbar">
    <a href="/pro/messages" class="back">←</a>
    <div class="avatar">
        @if($conversation->user?->avatar_url)
            <img src="{{ $conversation->user->avatar_url }}" alt="{{ $conversation->user->name ?? 'User' }}">
        @else
            {{ $conversation->user?->initials ?? 'U' }}
        @endif
    </div>
    <div>
        <div class="user-name">{{ $conversation->user->name ?? 'Customer' }}</div>
        <div class="user-email">{{ $conversation->user->email ?? '' }}</div>
    </div>
</div>

<div class="chat-box" id="chat-box">
    @forelse($messages as $msg)
    @php $isMe = $msg->sender_type === 'professional' @endphp
    <div class="msg-wrap {{ $isMe ? 'me' : '' }}">
        <div>
            <div class="bubble {{ $isMe ? 'bubble-me' : 'bubble-them' }}">{{ $msg->body }}</div>
            <div class="msg-time" style="text-align:{{ $isMe ? 'right' : 'left' }}">
                {{ $msg->created_at?->format('M j, g:i A') }}
            </div>
        </div>
    </div>
    @empty
    <div class="empty">No messages yet. Start the conversation!</div>
    @endforelse
</div>

<div class="send-bar">
    <form method="POST" action="/pro/messages/{{ $conversation->id }}/send" style="display:flex;gap:10px;flex:1">
        @csrf
        <input type="text" name="body" placeholder="Type a message..." required autocomplete="off">
        <button type="submit" class="btn-send">Send</button>
    </form>
</div>

<script>
    const box = document.getElementById('chat-box');
    if (box) box.scrollTop = box.scrollHeight;
</script>
</body>
</html>