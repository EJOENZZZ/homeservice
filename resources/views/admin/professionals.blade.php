@extends('admin.layout')
@section('page-title', 'Professionals')

@section('content')

<div style="display:flex;justify-content:flex-end;margin-bottom:20px">
    <button class="btn btn-blue" onclick="document.getElementById('addModal').classList.add('open')">
        + Add Professional
    </button>
</div>

<div class="card" style="padding:0;overflow:hidden;">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Specialty</th>
                    <th>Badge</th>
                    <th>Rating</th>
                    <th>Jobs</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($professionals as $pro)
                <tr>
                    <td>
                        @if($pro->avatar_url)
                            <img src="{{ $pro->avatar_url }}"
                                 style="width:40px;height:40px;border-radius:50%;object-fit:cover;border:2px solid var(--gray-border);">
                        @else
                            <div style="width:40px;height:40px;border-radius:50%;background:var(--blue);
                                        display:flex;align-items:center;justify-content:center;
                                        color:#fff;font-weight:700;font-size:.85rem;">
                                {{ $pro->initials }}
                            </div>
                        @endif
                    </td>
                    <td style="font-weight:600">{{ $pro->full_name }}</td>
                    <td style="font-size:.85rem;color:var(--gray-mid)">{{ $pro->email }}</td>
                    <td>{{ $pro->specialty }}</td>
                    <td>
                        <span class="badge badge-{{ strtolower(str_replace(' ','',$pro->badge)) }}">
                            {{ $pro->badge }}
                        </span>
                    </td>
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
                                onsubmit="return confirm('Reset password for {{ $pro->first_name }}?')">
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
                <tr>
                    <td colspan="9" style="text-align:center;color:#9CA3AF;padding:40px">No professionals yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:16px 24px;">{{ $professionals->links() }}</div>
</div>

{{-- ADD MODAL --}}
<div class="modal-overlay" id="addModal">
    <div class="modal">
        <div class="modal-title">Add Professional</div>
        <form method="POST" action="/admin/professionals" enctype="multipart/form-data">
            @csrf
            <div class="form-group" style="margin-bottom:20px;">
                <label>Profile Photo</label>
                <div style="display:flex;align-items:center;gap:16px;margin-top:8px;">
                    <div style="width:72px;height:72px;border-radius:50%;background:var(--gray-light);
                                border:2px dashed var(--gray-border);display:flex;align-items:center;
                                justify-content:center;overflow:hidden;flex-shrink:0;">
                        <span id="add_preview_text" style="font-size:.72rem;color:var(--gray-mid);text-align:center;">No photo</span>
                        <img id="add_preview_img" src="" style="display:none;width:100%;height:100%;object-fit:cover;">
                    </div>
                    <div>
                        <input type="file" name="photo" id="add_photo" accept="image/*" style="display:none;"
                               onchange="previewPhoto(this,'add_preview_img','add_preview_text')">
                        <button type="button" class="btn btn-ghost"
                                onclick="document.getElementById('add_photo').click()">Upload Photo</button>
                        <div style="font-size:.75rem;color:var(--gray-mid);margin-top:6px;">JPG, PNG, WEBP — max 2MB</div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group"><label>First Name</label><input type="text" name="first_name" required></div>
                <div class="form-group"><label>Last Name</label><input type="text" name="last_name" required></div>
            </div>
            <div class="form-group" style="margin-bottom:16px;">
                <label>Email</label>
                <input type="email" name="email" required placeholder="professional@email.com">
            </div>
            <div style="background:#EFF6FF;border:1px solid #BFDBFE;border-radius:8px;
                        padding:10px 14px;font-size:.82rem;color:#1D4ED8;margin-bottom:16px;">
                🔑 A temporary password will be auto-generated and emailed to the professional.
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
            <div class="form-group" style="margin-bottom:16px;">
                <label>Location</label>
                <input type="text" name="location" placeholder="e.g. Cebu City">
            </div>
            <div class="form-group" style="margin-bottom:20px;">
                <label>Bio</label>
                <textarea name="bio" rows="3"></textarea>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end">
                <button type="button" class="btn btn-ghost"
                        onclick="document.getElementById('addModal').classList.remove('open')">Cancel</button>
                <button type="submit" class="btn btn-blue">Create Account</button>
            </div>
        </form>
    </div>
</div>

{{-- EDIT MODAL --}}
<div class="modal-overlay" id="editModal">
    <div class="modal">
        <div class="modal-title">Edit Professional</div>
        <form method="POST" id="editForm" enctype="multipart/form-data">
            @csrf
            <div class="form-group" style="margin-bottom:20px;">
                <label>Profile Photo</label>
                <div style="display:flex;align-items:center;gap:16px;margin-top:8px;">
                    <div style="width:72px;height:72px;border-radius:50%;background:var(--gray-light);
                                border:2px dashed var(--gray-border);overflow:hidden;flex-shrink:0;">
                        <img id="edit_preview_img" src="" style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    <div>
                        <input type="file" name="photo" id="edit_photo" accept="image/*" style="display:none;"
                               onchange="previewPhoto(this,'edit_preview_img',null)">
                        <button type="button" class="btn btn-ghost"
                                onclick="document.getElementById('edit_photo').click()">Change Photo</button>
                        <div style="font-size:.75rem;color:var(--gray-mid);margin-top:6px;">Leave blank to keep current photo</div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group"><label>First Name</label><input type="text" name="first_name" id="e_first_name" required></div>
                <div class="form-group"><label>Last Name</label><input type="text" name="last_name" id="e_last_name" required></div>
            </div>
            <div class="form-group" style="margin-bottom:16px;">
                <label>Email</label>
                <input type="email" id="e_email_display"
                       style="background:var(--gray-light);color:var(--gray-mid);cursor:not-allowed;" readonly>
                <small style="color:var(--gray-mid);font-size:.75rem;">Email cannot be changed. Use Reset Password to resend credentials.</small>
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
            <div class="form-group" style="margin-bottom:20px;">
                <label>Bio</label>
                <textarea name="bio" id="e_bio" rows="3"></textarea>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end">
                <button type="button" class="btn btn-ghost"
                        onclick="document.getElementById('editModal').classList.remove('open')">Cancel</button>
                <button type="submit" class="btn btn-blue">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
function previewPhoto(input, imgId, textId) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById(imgId);
        img.src = e.target.result;
        img.style.display = 'block';
        if (textId) {
            const txt = document.getElementById(textId);
            if (txt) txt.style.display = 'none';
        }
    };
    reader.readAsDataURL(file);
}

function openEdit(pro) {
    document.getElementById('editForm').action = '/admin/professionals/' + pro.id;
    document.getElementById('e_first_name').value    = pro.first_name;
    document.getElementById('e_last_name').value     = pro.last_name;
    document.getElementById('e_email_display').value = pro.email;
    document.getElementById('e_specialty').value     = pro.specialty;
    document.getElementById('e_badge').value         = pro.badge;
    document.getElementById('e_rating').value        = pro.rating;
    document.getElementById('e_jobs_count').value    = pro.jobs_count;
    document.getElementById('e_hourly_rate').value   = pro.hourly_rate ?? '';
    document.getElementById('e_location').value      = pro.location ?? '';
    document.getElementById('e_bio').value           = pro.bio ?? '';
    document.getElementById('e_is_active').value     = pro.is_active ? '1' : '0';
    const img = document.getElementById('edit_preview_img');
    if (pro.avatar_url) {
        img.src = pro.avatar_url;
        img.style.display = 'block';
    } else {
        img.src = '';
        img.style.display = 'none';
    }
    document.getElementById('editModal').classList.add('open');
}

document.querySelectorAll('.modal-overlay').forEach(o => {
    o.addEventListener('click', e => { if (e.target === o) o.classList.remove('open'); });
});
</script>

@endsection