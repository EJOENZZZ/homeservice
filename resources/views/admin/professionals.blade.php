@extends('admin.layout')
@section('page-title', 'Professionals')

@section('content')

<div style="display:flex;justify-content:flex-end;margin-bottom:20px">
    <button class="btn btn-blue" onclick="document.getElementById('addModal').classList.add('open')">
        + Add Professional
    </button>
</div>

<div class="card">
    <div class="card-title">All Professionals</div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Name</th><th>Specialty</th><th>Badge</th><th>Rating</th><th>Jobs</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($professionals as $pro)
                <tr>
                    <td style="font-weight:600">{{ $pro->first_name }} {{ $pro->last_name }}</td>
                    <td>{{ $pro->specialty }}</td>
                    <td><span class="badge badge-{{ strtolower(str_replace(' ','',$pro->badge)) }}">{{ $pro->badge }}</span></td>
                    <td>⭐ {{ number_format($pro->rating,2) }}</td>
                    <td>{{ $pro->jobs_count }}</td>
                    <td>
                        <span class="badge {{ $pro->is_active ? 'badge-verified' : 'badge-unverified' }}">
                            {{ $pro->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
    <div style="display:flex;gap:6px;flex-wrap:wrap">
        <button class="btn btn-amber" onclick="openEdit({{ $pro->toJson() }})">Edit</button>
        <form method="POST" action="/admin/professionals/{{ $pro->id }}/reset"
            onsubmit="return confirm('Reset password for {{ $pro->first_name }}? New credentials will be emailed.')">
            @csrf
            <button type="submit" class="btn btn-blue" style="font-size:.75rem">Reset Pass</button>
        </form>
        <form method="POST" action="/admin/professionals/{{ $pro->id }}/toggle">
            @csrf
            <button type="submit" class="btn {{ $pro->is_active ? 'btn-amber' : 'btn-green' }}" style="font-size:.75rem">
                {{ $pro->is_active ? 'Deactivate' : 'Activate' }}
            </button>
        </form>
        <form method="POST" action="/admin/professionals/{{ $pro->id }}"
            onsubmit="return confirm('Delete {{ $pro->first_name }}?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-red">Delete</button>
        </form>
    </div>
</td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;color:#9CA3AF;padding:40px">No professionals yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $professionals->links() }}</div>
</div>

{{-- ADD MODAL --}}
<div class="modal-overlay" id="addModal">
    <div class="modal">
        <div class="modal-title">Add Professional</div>
        <form method="POST" action="/admin/professionals">
            @csrf
            <div class="form-row">
                <div class="form-group"><label>First Name</label><input type="text" name="first_name" required></div>
                <div class="form-group"><label>Last Name</label><input type="text" name="last_name" required></div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Specialty</label>
                    <select name="specialty" required>
                        @foreach(['Plumbing','Electrical','Carpentry','Cleaning','Painting'] as $s)
                        <option>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Badge</label>
                    <select name="badge">
                        <option>VERIFIED</option><option>TOP PRO</option><option>ELITE</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group"><label>Rating</label><input type="number" name="rating" step="0.01" min="0" max="5" value="5.00" required></div>
                <div class="form-group"><label>Jobs Count</label><input type="number" name="jobs_count" value="0" required></div>
                <div class="form-group"><label>Hourly Rate (₱)</label><input type="number" name="hourly_rate" step="0.01"></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label>Location</label><input type="text" name="location" placeholder="e.g. Cebu City"></div>
            </div>
            <div class="form-group" style="margin-bottom:20px"><label>Bio</label><textarea name="bio" rows="3"></textarea></div>
            <div style="display:flex;gap:10px;justify-content:flex-end">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('addModal').classList.remove('open')">Cancel</button>
                <button type="submit" class="btn btn-blue">Add Professional</button>
            </div>
        </form>
    </div>
</div>

{{-- EDIT MODAL --}}
<div class="modal-overlay" id="editModal">
    <div class="modal">
        <div class="modal-title">Edit Professional</div>
        <form method="POST" id="editForm">
            @csrf
            <div class="form-row">
                <div class="form-group"><label>First Name</label><input type="text" name="first_name" id="e_first_name" required></div>
                <div class="form-group"><label>Last Name</label><input type="text" name="last_name" id="e_last_name" required></div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Specialty</label>
                    <select name="specialty" id="e_specialty">
                        @foreach(['Plumbing','Electrical','Carpentry','Cleaning','Painting'] as $s)
                        <option>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Badge</label>
                    <select name="badge" id="e_badge">
                        <option>VERIFIED</option><option>TOP PRO</option><option>ELITE</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group"><label>Rating</label><input type="number" name="rating" id="e_rating" step="0.01" min="0" max="5" required></div>
                <div class="form-group"><label>Jobs Count</label><input type="number" name="jobs_count" id="e_jobs_count" required></div>
                <div class="form-group"><label>Hourly Rate (₱)</label><input type="number" name="hourly_rate" id="e_hourly_rate" step="0.01"></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label>Location</label><input type="text" name="location" id="e_location"></div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="is_active" id="e_is_active">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="form-group" style="margin-bottom:20px"><label>Bio</label><textarea name="bio" id="e_bio" rows="3"></textarea></div>
            <div style="display:flex;gap:10px;justify-content:flex-end">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('editModal').classList.remove('open')">Cancel</button>
                <button type="submit" class="btn btn-blue">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEdit(pro) {
    document.getElementById('editForm').action = '/admin/professionals/' + pro.id;
    document.getElementById('e_first_name').value  = pro.first_name;
    document.getElementById('e_last_name').value   = pro.last_name;
    document.getElementById('e_specialty').value   = pro.specialty;
    document.getElementById('e_badge').value       = pro.badge;
    document.getElementById('e_rating').value      = pro.rating;
    document.getElementById('e_jobs_count').value  = pro.jobs_count;
    document.getElementById('e_hourly_rate').value = pro.hourly_rate ?? '';
    document.getElementById('e_location').value    = pro.location ?? '';
    document.getElementById('e_bio').value         = pro.bio ?? '';
    document.getElementById('e_is_active').value   = pro.is_active ? '1' : '0';
    document.getElementById('editModal').classList.add('open');
}
document.querySelectorAll('.modal-overlay').forEach(o => {
    o.addEventListener('click', e => { if(e.target === o) o.classList.remove('open'); });
});
</script>
@endsection