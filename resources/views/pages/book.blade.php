@extends('layouts.app')

@section('content')
<div class="auth-wrap">
    <div class="auth-card" style="max-width:580px">
        <h1 class="auth-title">Book a Service</h1>

        {{-- PRO SUMMARY --}}
        <div class="booking-pro-summary">
            <div class="pro-avatar" style="margin:0;width:48px;height:48px;font-size:.95rem">
                {{ strtoupper(substr($pro->first_name,0,1).substr($pro->last_name,0,1)) }}
            </div>
            <div>
                <div style="font-weight:700;font-family:'Syne',sans-serif">{{ $pro->first_name }} {{ $pro->last_name }}</div>
                <div style="font-size:.85rem;color:var(--gray-mid)">{{ $pro->specialty }} · ★ {{ number_format($pro->rating,2) }}</div>
            </div>
        </div>

        <div style="background:#F8FAFC;border:1.5px solid var(--gray-border);border-radius:12px;padding:14px 16px;margin-bottom:20px">
            <div style="font-size:.75rem;font-weight:700;color:var(--gray-mid);letter-spacing:.06em;margin-bottom:4px">PROFESSIONAL AVAILABILITY</div>
            <div style="font-size:.92rem;color:var(--black);line-height:1.5;font-weight:600">
                {{ $pro->availability ?: 'Availability has not been set by this professional yet.' }}
            </div>
        </div>

        @if($errors->any())
        <div class="form-error-box" style="background:#FEF2F2;border:1px solid #FECACA;border-radius:10px;padding:14px 16px;margin-bottom:20px;color:#991B1B;font-size:.88rem">
            <ul style="margin:0;padding-left:16px">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="/book" class="auth-form" id="booking-form">
            @csrf
            <input type="hidden" name="professional_id" value="{{ $pro->id }}">

            <div class="form-group">
                <label>Service Date</label>
                <input type="date" name="service_date" id="service_date"
                    value="{{ old('service_date') }}"
                    min="{{ date('Y-m-d') }}" required>
            </div>

            <div class="form-group">
                <label>Preferred Time</label>
                <input type="time" name="service_time" id="service_time"
                    value="{{ old('service_time') }}" required>
            </div>

            <div class="form-group">
                <label>Estimated Hours</label>
                <select name="estimated_hours" id="estimated_hours"
                    required
                    style="width:100%;border:1.5px solid var(--gray-border);border-radius:10px;padding:10px 14px;font-size:.92rem;font-family:'DM Sans',sans-serif;outline:none;background:#fff">
                    <option value="">Select estimated hours...</option>
                    @for($h = 1; $h <= 8; $h++)
                    <option value="{{ $h }}" {{ old('estimated_hours') == $h ? 'selected' : '' }}>
                        {{ $h }} hour{{ $h > 1 ? 's' : '' }}
                    </option>
                    @endfor
                </select>
            </div>

            <div class="form-group">
                <label>Your Address</label>
                <input type="text" name="address" id="address"
                    value="{{ old('address') }}"
                    placeholder="123 Rizal St, Cebu City" required>
            </div>

            <div class="form-group">
                <label>Notes (optional)</label>
                <textarea name="notes" rows="3"
                    placeholder="Describe what needs to be done...">{{ old('notes') }}</textarea>
            </div>

            {{-- PAYMENT METHOD --}}
            <div class="form-group">
                <label>Payment Method</label>
                <div style="display:flex;flex-direction:column;gap:10px;margin-top:6px">

                    <label id="pay-gcash-wrap"
                        style="cursor:pointer;display:flex;align-items:flex-start;gap:12px;background:#F0FDF4;border:2px solid #22C55E;border-radius:12px;padding:14px 16px;transition:all .2s"
                        onclick="selectPayment('gcash')">
                        <input type="radio" name="payment_method" value="gcash" id="pay-gcash"
                            style="margin-top:3px;accent-color:#22C55E" checked>
                        <div style="flex:1">
                            <div style="font-weight:700;font-size:.92rem;color:#15803D">💚 GCash (Pay Before Service)</div>
                            <div style="font-size:.8rem;color:#166534;margin-top:2px">Send payment via GCash before the scheduled date. QR code will be shown after confirming.</div>
                        </div>
                    </label>

                    <label id="pay-after-wrap"
                        style="cursor:pointer;display:flex;align-items:flex-start;gap:12px;background:#fff;border:2px solid var(--gray-border);border-radius:12px;padding:14px 16px;transition:all .2s"
                        onclick="selectPayment('after_service')">
                        <input type="radio" name="payment_method" value="after_service" id="pay-after"
                            style="margin-top:3px;accent-color:var(--blue)">
                        <div style="flex:1">
                            <div style="font-weight:700;font-size:.92rem;color:var(--black)">💵 Cash After Service</div>
                            <div style="font-size:.8rem;color:var(--gray-mid);margin-top:2px">Pay in cash directly to the professional after the job is done.</div>
                        </div>
                    </label>

                </div>
            </div>

            {{-- BOOKING SUMMARY --}}
            <div id="booking-summary"
                style="background:#EFF6FF;border:2px solid #BFDBFE;border-radius:16px;padding:20px;margin-top:4px;margin-bottom:8px;display:none">
                <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:.95rem;color:#1E40AF;margin-bottom:14px">
                    🧾 Booking Summary
                </div>
                <div style="display:flex;flex-direction:column;gap:9px;font-size:.88rem">
                    <div style="display:flex;justify-content:space-between">
                        <span style="color:#3B82F6">Professional</span>
                        <span style="font-weight:700;color:#1E3A8A">{{ $pro->first_name }} {{ $pro->last_name }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between">
                        <span style="color:#3B82F6">Rate</span>
                        <span style="font-weight:700;color:#1E3A8A">₱{{ number_format($pro->hourly_rate ?? 350) }} / hour</span>
                    </div>
                    <div style="display:flex;justify-content:space-between">
                        <span style="color:#3B82F6">Date &amp; Time</span>
                        <span style="font-weight:700;color:#1E3A8A" id="summary-datetime">—</span>
                    </div>
                    <div style="display:flex;justify-content:space-between">
                        <span style="color:#3B82F6">Estimated Hours</span>
                        <span style="font-weight:700;color:#1E3A8A" id="summary-hours">—</span>
                    </div>
                    <div style="display:flex;justify-content:space-between">
                        <span style="color:#3B82F6">Payment</span>
                        <span style="font-weight:700;color:#1E3A8A" id="summary-payment">GCash</span>
                    </div>
                    <div style="border-top:1.5px solid #BFDBFE;margin:4px 0;padding-top:10px;display:flex;justify-content:space-between;align-items:center">
                        <span style="color:#1E40AF;font-weight:700;font-size:.95rem">Estimated Total</span>
                        <span style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.25rem;color:#1E3A8A" id="summary-total">—</span>
                    </div>
                </div>
                <div style="margin-top:12px;padding:10px 12px;background:#DBEAFE;border-radius:10px;font-size:.78rem;color:#1E40AF;line-height:1.5">
                    ℹ️ Final amount may vary depending on actual hours worked. This is an estimate only.
                </div>
            </div>

            <button type="submit" class="btn-primary btn-full" style="margin-top:8px">
                Confirm Booking
            </button>
        </form>
    </div>
</div>

{{-- GCASH QR MODAL --}}
<div id="gcash-modal"
    style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.55);align-items:center;justify-content:center">
    <div style="background:#fff;border-radius:24px;padding:36px 28px;max-width:380px;width:92%;text-align:center;box-shadow:0 24px 80px rgba(0,0,0,.25)">
        <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.2rem;margin-bottom:4px">GCash Payment</div>
        <div style="color:var(--gray-mid);font-size:.85rem;margin-bottom:20px">Scan the QR code to pay before your scheduled service</div>

        <div style="background:#F0FDF4;border:2px dashed #22C55E;border-radius:16px;padding:20px;margin-bottom:18px;display:inline-block">
            <div id="qrcode" style="margin:0 auto"></div>
        </div>

        <div style="background:#F0FDF4;border-radius:12px;padding:14px 16px;margin-bottom:18px">
            <div style="font-size:.72rem;color:#166534;font-weight:700;letter-spacing:.07em;margin-bottom:4px">SEND PAYMENT TO</div>
            <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.1rem;color:#15803D">{{ $pro->first_name }} {{ $pro->last_name }}</div>
            @if(!empty($pro->phone))
            <div style="font-size:.88rem;color:#166534;margin-top:4px;font-weight:600">{{ $pro->phone }}</div>
            @endif
            <div style="font-size:.78rem;color:#166534;margin-top:2px">GCash Account</div>
        </div>

        <div style="background:#EFF6FF;border-radius:10px;padding:12px 14px;margin-bottom:20px;font-size:.85rem;color:#1E40AF">
            Estimated Total: <strong id="modal-total" style="font-size:1rem">—</strong><br>
            <span style="font-size:.76rem">Please send the exact amount and keep your screenshot as proof.</span>
        </div>

        <button onclick="closeGcashModal()" class="btn-primary" style="width:100%;justify-content:center;margin-bottom:10px">
            Done — I've Sent Payment ✓
        </button>
        <button onclick="closeGcashModal()" style="background:none;border:none;color:var(--gray-mid);font-size:.85rem;cursor:pointer;width:100%">
            I'll pay later
        </button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
const hourlyRate = {{ $pro->hourly_rate ?? 350 }};
const proName    = "{{ $pro->first_name }} {{ $pro->last_name }}";
const proPhone   = "{{ $pro->phone ?? '' }}";
const proAvailability = @json($pro->availability ?? '');
let qrGenerated  = false;
let formSubmitting = false;

function timeToMinutes(hour, minute, period) {
    hour = parseInt(hour, 10) % 12;
    minute = parseInt(minute || 0, 10);
    if (period.toUpperCase() === 'PM') hour += 12;
    return (hour * 60) + minute;
}

function selectedTimeToMinutes(time) {
    const parts = time.split(':').map(Number);
    return (parts[0] * 60) + parts[1];
}

function availabilityWindow() {
    if (!proAvailability) return null;
    const match = proAvailability.match(/(\d{1,2})(?::(\d{2}))?\s*(AM|PM)\s*-\s*(\d{1,2})(?::(\d{2}))?\s*(AM|PM)/i);
    if (!match) {
        const until = proAvailability.match(/until\s*(\d{1,2})(?::(\d{2}))?\s*(AM|PM)?/i);
        if (!until) return null;

        const period = until[3] || (parseInt(until[1], 10) <= 7 ? 'PM' : 'AM');
        return [0, timeToMinutes(until[1], until[2] || 0, period)];
    }
    return [
        timeToMinutes(match[1], match[2] || 0, match[3]),
        timeToMinutes(match[4], match[5] || 0, match[6])
    ];
}

function isSelectedTimeAvailable() {
    const time = document.getElementById('service_time').value;
    const range = availabilityWindow();
    if (!time || !range) return true;

    const selected = selectedTimeToMinutes(time);
    return selected >= range[0] && selected <= range[1];
}

function showUnavailableTimeAlert() {
    alert('The professional is not available at this time. Please choose a time within: ' + proAvailability);
}

function selectPayment(method) {
    const gcashWrap = document.getElementById('pay-gcash-wrap');
    const afterWrap = document.getElementById('pay-after-wrap');
    if (method === 'gcash') {
        gcashWrap.style.background  = '#F0FDF4';
        gcashWrap.style.borderColor = '#22C55E';
        afterWrap.style.background  = '#fff';
        afterWrap.style.borderColor = 'var(--gray-border)';
        document.getElementById('pay-gcash').checked = true;
    } else {
        afterWrap.style.background  = '#EFF6FF';
        afterWrap.style.borderColor = 'var(--blue)';
        gcashWrap.style.background  = '#fff';
        gcashWrap.style.borderColor = 'var(--gray-border)';
        document.getElementById('pay-after').checked = true;
    }
    updateSummary();
}

function updateSummary() {
    const date    = document.getElementById('service_date').value;
    const time    = document.getElementById('service_time').value;
    const hours   = parseInt(document.getElementById('estimated_hours').value) || 0;
    const method  = document.querySelector('input[name="payment_method"]:checked')?.value;
    const summary = document.getElementById('booking-summary');

    if (!date && !hours) { summary.style.display = 'none'; return; }
    summary.style.display = 'block';

    if (date && time) {
        const d = new Date(date + 'T' + time);
        document.getElementById('summary-datetime').textContent =
            d.toLocaleDateString('en-PH', { month:'short', day:'numeric', year:'numeric' }) +
            ' @ ' + d.toLocaleTimeString('en-PH', { hour:'numeric', minute:'2-digit', hour12:true });
    }

    if (hours) {
        document.getElementById('summary-hours').textContent = hours + ' hour' + (hours > 1 ? 's' : '');
        const total = hourlyRate * hours;
        const fmt   = '₱' + total.toLocaleString();
        document.getElementById('summary-total').textContent = fmt;
        document.getElementById('modal-total').textContent   = fmt;
    }

    document.getElementById('summary-payment').textContent =
        method === 'gcash' ? 'GCash' : 'Cash After Service';
}

document.getElementById('service_date').addEventListener('change', updateSummary);
document.getElementById('service_time').addEventListener('change', updateSummary);
document.getElementById('service_time').addEventListener('change', function() {
    if (!isSelectedTimeAvailable()) {
        showUnavailableTimeAlert();
        this.value = '';
        updateSummary();
    }
});
document.getElementById('estimated_hours').addEventListener('change', updateSummary);

document.getElementById('booking-form').addEventListener('submit', function(e) {
    if (formSubmitting) return;
    if (!isSelectedTimeAvailable()) {
        e.preventDefault();
        showUnavailableTimeAlert();
        return;
    }
    const method = document.querySelector('input[name="payment_method"]:checked')?.value;
    if (method === 'gcash') {
        e.preventDefault();
        showGcashModal();
    }
});

function showGcashModal() {
    document.getElementById('gcash-modal').style.display = 'flex';
    if (!qrGenerated) {
        const qrContent = proPhone
            ? 'GCash Payment to ' + proName + ' | ' + proPhone
            : 'GCash Payment to ' + proName;
        new QRCode(document.getElementById('qrcode'), {
            text: qrContent, width: 180, height: 180,
            colorDark: '#15803D', colorLight: '#F0FDF4',
        });
        qrGenerated = true;
    }
}

function closeGcashModal() {
    document.getElementById('gcash-modal').style.display = 'none';
    formSubmitting = true;
    document.getElementById('booking-form').submit();
}

document.getElementById('gcash-modal').addEventListener('click', function(e) {
    if (e.target === this) closeGcashModal();
});

document.addEventListener('DOMContentLoaded', function() {
    selectPayment('gcash');
    updateSummary();
});
</script>
@endsection
