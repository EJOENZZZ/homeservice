@extends('admin.layout')
@section('page-title', 'Contact Messages')

@section('content')
<div class="card">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
        <h2 class="card-title" style="margin-bottom:0">Contact Messages</h2>
        <span style="font-size:.82rem;color:var(--gray-mid)">{{ $messages->total() }} total &mdash; {{ $unread }} unread</span>
    </div>

    @if($messages->isEmpty())
    <div style="text-align:center;padding:60px 0;color:var(--gray-mid)">
        <div style="font-size:2.5rem;margin-bottom:12px">✉️</div>
        <div style="font-weight:600">No messages yet</div>
    </div>
    @else
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>FROM</th>
                    <th>SUBJECT</th>
                    <th>DATE</th>
                    <th>STATUS</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($messages as $msg)
                <tr style="{{ !$msg->is_read ? 'background:#FAFBFF' : '' }}">
                    <td>
                        <div style="font-weight:{{ $msg->is_read ? '400' : '700' }};font-size:.88rem">{{ $msg->name }}</div>
                        <div style="font-size:.78rem;color:var(--gray-mid)">{{ $msg->email }}</div>
                    </td>
                    <td style="font-weight:{{ $msg->is_read ? '400' : '600' }}">{{ $msg->subject }}</td>
                    <td style="font-size:.82rem;color:var(--gray-mid);white-space:nowrap">{{ $msg->created_at->format('M j, Y g:i A') }}</td>
                    <td>
                        @if($msg->is_read)
                            <span class="badge" style="background:#F3F4F6;color:#6B7280">Read</span>
                        @else
                            <span class="badge badge-confirmed">New</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:8px">
                            <button onclick="openMsg({{ $msg->id }})" class="btn btn-ghost" style="font-size:.78rem;padding:5px 12px">View</button>
                            <form method="POST" action="/admin/contact-messages/{{ $msg->id }}" onsubmit="return confirm('Delete this message?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-red" style="font-size:.78rem;padding:5px 12px">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $messages->links() }}</div>
    @endif
</div>

{{-- Message detail modals --}}
@foreach($messages as $msg)
<div id="msg-{{ $msg->id }}" class="modal-overlay">
    <div class="modal" style="max-width:540px">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px">
            <div>
                <div class="modal-title" style="margin-bottom:4px">{{ $msg->subject }}</div>
                <div style="font-size:.82rem;color:var(--gray-mid)">From <strong>{{ $msg->name }}</strong> &lt;{{ $msg->email }}&gt;</div>
                <div style="font-size:.78rem;color:var(--gray-mid);margin-top:3px">{{ $msg->created_at->format('F j, Y \a\t g:i A') }}</div>
            </div>
            <button onclick="closeMsg({{ $msg->id }})" style="background:none;border:none;cursor:pointer;font-size:1.4rem;color:var(--gray-mid);line-height:1">&times;</button>
        </div>
        <div style="background:#F8FAFC;border:1px solid var(--gray-border);border-radius:10px;padding:18px;font-size:.9rem;line-height:1.7;white-space:pre-wrap">{{ $msg->message }}</div>
        <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px">
            <a href="mailto:{{ $msg->email }}?subject=Re: {{ urlencode($msg->subject) }}" class="btn btn-blue">Reply via Email</a>
            <button onclick="closeMsg({{ $msg->id }})" class="btn btn-ghost">Close</button>
        </div>
    </div>
</div>
@endforeach

<script>
function openMsg(id) {
    document.getElementById('msg-' + id).classList.add('open');
    fetch('/admin/contact-messages/' + id + '/read', { method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'} });
}
function closeMsg(id) {
    document.getElementById('msg-' + id).classList.remove('open');
}
document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', function(e) { if (e.target === el) el.classList.remove('open'); });
});
</script>
@endsection
