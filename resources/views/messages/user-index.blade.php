@extends('layouts.app')

@section('content')
<div style="max-width:700px;margin:0 auto;padding:40px 24px 80px">
    <h1 style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.8rem;margin-bottom:28px">My Messages</h1>

    @if($conversations->isEmpty())
    <div style="text-align:center;padding:60px 20px;color:var(--gray-mid)">
        <div style="font-size:3rem;margin-bottom:16px">💬</div>
        <h3 style="font-family:'Syne',sans-serif;font-weight:700;margin-bottom:8px">No conversations yet</h3>
        <p style="margin-bottom:20px">Find a professional and start chatting!</p>
        <a href="/services" class="btn-primary">Browse Professionals</a>
    </div>
    @else
    <div style="display:flex;flex-direction:column;gap:12px">
        @foreach($conversations as $conv)
        @php $pro = $conv->professional; $latest = $conv->latestMessage; @endphp
        <a href="/messages/{{ $pro->id }}" style="text-decoration:none">
            <div style="background:#fff;border:1.5px solid var(--gray-border);border-radius:16px;padding:18px 20px;display:flex;align-items:center;gap:16px;transition:box-shadow .2s" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,.08)'" onmouseout="this.style.boxShadow=''">
                @if($pro->avatar_url)
                    <img src="{{ $pro->avatar_url }}" style="width:52px;height:52px;border-radius:50%;object-fit:cover;flex-shrink:0">
                @else
                    <div style="width:52px;height:52px;border-radius:50%;background:var(--blue-light);display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-weight:700;color:var(--blue);flex-shrink:0">
                        {{ strtoupper(substr($pro->first_name,0,1).substr($pro->last_name,0,1)) }}
                    </div>
                @endif
                <div style="flex:1;min-width:0">
                    <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:.95rem">{{ $pro->full_name }}</div>
                    <div style="font-size:.8rem;color:var(--gray-mid)">{{ $pro->specialty }}</div>
                    @if($latest)
                    <div style="font-size:.82rem;color:var(--gray-mid);margin-top:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                        {{ $latest->sender_type === 'user' ? 'You: ' : '' }}{{ $latest->body }}
                    </div>
                    @endif
                </div>
                @if($latest)
                <div style="font-size:.75rem;color:var(--gray-mid);flex-shrink:0">{{ $latest->created_at?->diffForHumans() }}</div>
                @endif
            </div>
        </a>
        @endforeach
    </div>
    @endif
</div>
@endsection