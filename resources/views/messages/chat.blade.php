@extends('layouts.app')

@section('content')
<div style="max-width:800px;margin:0 auto;padding:32px 24px 80px">

    <a href="/messages" style="display:inline-flex;align-items:center;gap:8px;color:var(--gray-mid);text-decoration:none;font-size:.88rem;margin-bottom:20px">
        ← Back to Messages
    </a>

    <div style="background:#fff;border:1.5px solid var(--gray-border);border-radius:20px;overflow:hidden">

        {{-- CHAT HEADER --}}
        <div style="padding:20px 24px;border-bottom:1px solid var(--gray-border);display:flex;align-items:center;gap:14px">
            @if($pro->avatar_url)
                <img src="{{ $pro->avatar_url }}" style="width:48px;height:48px;border-radius:50%;object-fit:cover">
            @else
                <div style="width:48px;height:48px;border-radius:50%;background:var(--blue-light);display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-weight:700;color:var(--blue)">
                    {{ strtoupper(substr($pro->first_name,0,1).substr($pro->last_name,0,1)) }}
                </div>
            @endif
            <div>
                <div style="font-family:'Syne',sans-serif;font-weight:700">{{ $pro->first_name }} {{ $pro->last_name }}</div>
                <div style="font-size:.82rem;color:var(--gray-mid)">{{ $pro->specialty }}</div>
            </div>
            <a href="/pros/{{ $pro->id }}" class="btn-outline" style="margin-left:auto;font-size:.8rem">View Profile</a>
        </div>

        {{-- MESSAGES --}}
        <div id="chat-box" style="padding:24px;display:flex;flex-direction:column;gap:12px;min-height:400px;max-height:500px;overflow-y:auto;background:#F8FAFC">
            @forelse($messages as $msg)
            @php $isMe = $msg->sender_type === 'user' @endphp
            <div style="display:flex;justify-content:{{ $isMe ? 'flex-end' : 'flex-start' }}">
                <div style="max-width:70%">
                    <div style="background:{{ $isMe ? 'var(--blue)' : '#fff' }};color:{{ $isMe ? '#fff' : 'var(--black)' }};padding:12px 16px;border-radius:{{ $isMe ? '18px 18px 4px 18px' : '18px 18px 18px 4px' }};font-size:.9rem;line-height:1.5;border:{{ $isMe ? 'none' : '1px solid var(--gray-border)' }}">
                        {{ $msg->body }}
                    </div>
                    <div style="font-size:.72rem;color:var(--gray-mid);margin-top:4px;text-align:{{ $isMe ? 'right' : 'left' }}">
                        {{ $msg->created_at?->format('M j, g:i A') }}
                    </div>
                </div>
            </div>
            @empty
            <div style="text-align:center;color:var(--gray-mid);padding:40px;font-size:.9rem">
                No messages yet. Say hello! 👋
            </div>
            @endforelse
        </div>

        {{-- SEND MESSAGE --}}
        <div style="padding:16px 24px;border-top:1px solid var(--gray-border);background:#fff">
            <form method="POST" action="/messages/{{ $conversation->id }}/send" style="display:flex;gap:10px">
                @csrf
                <input type="text" name="body" placeholder="Type a message..."
                    style="flex:1;border:1.5px solid var(--gray-border);border-radius:30px;padding:10px 18px;font-size:.92rem;font-family:'DM Sans',sans-serif;outline:none"
                    required autocomplete="off">
                <button type="submit" class="btn-primary" style="border-radius:30px;padding:10px 24px">Send</button>
            </form>
        </div>
    </div>
</div>

<script>
    const box = document.getElementById('chat-box');
    if (box) box.scrollTop = box.scrollHeight;
</script>
@endsection