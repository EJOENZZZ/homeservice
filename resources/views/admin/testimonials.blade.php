@extends('admin.layout')
@section('page-title', 'Testimonials')

@section('content')

<div class="card">
    <div class="card-title">All Testimonials</div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Author</th><th>Review</th><th>Rating</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($testimonials as $t)
                <tr>
                    <td style="font-weight:600;white-space:nowrap">{{ $t->author_name }}</td>
                    <td style="max-width:300px;font-size:.85rem;color:#374151">{{ $t->content }}</td>
                    <td>{{ str_repeat('⭐', $t->rating) }}</td>
                    <td>
                        <span class="badge {{ $t->is_approved ? 'badge-verified' : 'badge-unverified' }}">
                            {{ $t->is_approved ? 'Approved' : 'Pending' }}
                        </span>
                    </td>
                    <td style="display:flex;gap:6px;flex-wrap:wrap">
                        @if(!$t->is_approved)
                        <form method="POST" action="/admin/testimonials/{{ $t->id }}/approve">
                            @csrf
                            <button type="submit" class="btn btn-green">Approve</button>
                        </form>
                        @endif
                        <form method="POST" action="/admin/testimonials/{{ $t->id }}" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-red">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;color:#9CA3AF;padding:40px">No testimonials yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $testimonials->links() }}</div>
</div>

@endsection