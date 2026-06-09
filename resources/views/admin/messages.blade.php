@extends('admin.layout')
@section('page-title', 'Messages')

@section('content')
<div class="card">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;gap:12px;flex-wrap:wrap">
        <div>
            <h2 class="card-title" style="margin-bottom:4px">Pro Messages</h2>
            <div style="font-size:.82rem;color:var(--gray-mid)">See who contacted who, with professional photo and name shown first</div>
        </div>
        <span style="font-size:.82rem;color:var(--gray-mid)">{{ $conversations->total() }} conversations</span>
    </div>

    @if($conversations->isEmpty())
    <div style="text-align:center;padding:60px 0;color:var(--gray-mid)">
        <div style="font-size:2.5rem;margin-bottom:12px">💬</div>
        <div style="font-weight:600">No conversations yet</div>
    </div>
    @else
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>PROFESSIONAL</th>
                    <th>CUSTOMER</th>
                    <th>LAST MESSAGE</th>
                    <th>UPDATED</th>
                </tr>
            </thead>
            <tbody>
                @foreach($conversations as $conv)
                @php
                    $pro = $conv->professional;
                    $user = $conv->user;
                    $latest = $conv->latestMessage;
                @endphp
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="width:42px;height:42px;border-radius:50%;background:var(--blue-light);color:var(--blue);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.78rem;overflow:hidden;flex-shrink:0;">
                                @if($pro?->avatar_url)
                                    <img src="{{ $pro->avatar_url }}" alt="{{ $pro->full_name ?? 'Professional' }}" style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    {{ $pro?->initials ?? 'P' }}
                                @endif
                            </div>
                            <div>
                                <div style="font-weight:700;line-height:1.2">{{ $pro->full_name ?? 'Professional' }}</div>
                                <div style="font-size:.78rem;color:var(--gray-mid);line-height:1.2">{{ $pro->specialty ?? '—' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="font-weight:600;line-height:1.2">{{ $user->name ?? 'Customer' }}</div>
                        <div style="font-size:.78rem;color:var(--gray-mid);line-height:1.2">{{ $user->email ?? '' }}</div>
                    </td>
                    <td style="max-width:360px">
                        @if($latest)
                            <div style="font-weight:600;margin-bottom:4px">
                                {{ $latest->sender_type === 'professional' ? 'Pro' : 'Customer' }}:
                            </div>
                            <div style="color:var(--gray-mid);font-size:.86rem;line-height:1.5;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                {{ $latest->body }}
                            </div>
                        @else
                            <span style="color:var(--gray-mid)">No messages yet</span>
                        @endif
                    </td>
                    <td style="font-size:.82rem;color:var(--gray-mid);white-space:nowrap">
                        {{ $latest?->created_at?->diffForHumans() ?? '—' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination">{{ $conversations->links() }}</div>
    @endif
</div>
@endsection