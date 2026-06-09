<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages — HomeFix Pro</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: #0A1628; color: #fff; min-height: 100vh; padding: 32px 24px; }
        .wrap { max-width: 700px; margin: 0 auto; }
        .header { display: flex; align-items: center; gap: 16px; margin-bottom: 28px; }
        .back { color: #64748B; text-decoration: none; font-size: .85rem; }
        h1 { font-family: 'Syne', sans-serif; font-size: 1.5rem; font-weight: 800; }
        .conv-list { display: flex; flex-direction: column; gap: 10px; }
        .conv-item { background: #1E293B; border: 1px solid #334155; border-radius: 14px; padding: 16px 18px; display: flex; align-items: center; gap: 14px; text-decoration: none; color: #fff; transition: background .2s; }
        .conv-item:hover { background: #263548; }
        .avatar { width: 48px; height: 48px; border-radius: 50%; background: #2563EB; display: flex; align-items: center; justify-content: center; font-family: 'Syne', sans-serif; font-weight: 700; font-size: .9rem; flex-shrink: 0; overflow: hidden; }
        .avatar img { width: 100%; height: 100%; object-fit: cover; }
        .info { flex: 1; min-width: 0; }
        .name { font-family: 'Syne', sans-serif; font-weight: 700; font-size: .92rem; margin-bottom: 2px; }
        .preview { font-size: .8rem; color: #64748B; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .time { font-size: .72rem; color: #475569; flex-shrink: 0; }
        .unread-dot { width: 8px; height: 8px; background: #2563EB; border-radius: 50%; flex-shrink: 0; }
        .empty { text-align: center; padding: 60px 20px; color: #475569; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="header">
        <a href="/pro/dashboard" class="back">← Dashboard</a>
        <h1>Messages</h1>
    </div>

    @if($conversations->isEmpty())
    <div class="empty">
        <div style="font-size:3rem;margin-bottom:16px">💬</div>
        <p>No conversations yet. Customers will message you after booking.</p>
    </div>
    @else
    <div class="conv-list">
        @foreach($conversations as $conv)
        @php $user = $conv->user; $latest = $conv->latestMessage; @endphp
        <a href="/pro/messages/{{ $conv->id }}" class="conv-item">
            <div class="avatar">
                @if($user?->avatar_url)
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name ?? 'User' }}">
                @else
                    {{ $user?->initials ?? 'U' }}
                @endif
            </div>
            <div class="info">
                <div class="name">{{ $user->name ?? 'Unknown' }}</div>
                @if($latest)
                <div class="preview">{{ $latest->sender_type === 'professional' ? 'You: ' : '' }}{{ $latest->body }}</div>
                @endif
            </div>
            @if($latest)
            <div class="time">{{ $latest->created_at?->diffForHumans() }}</div>
            @endif
        </a>
        @endforeach
    </div>
    @endif
</div>
</body>
</html>