@extends('admin.layouts.main')

@section('title', 'Pengaturan Kontak Admin')

@section('content')
<div class="container-fluid py-2">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h1 class="h3 mb-4 text-gray-800">
                <i class="fas fa-phone-alt text-primary mr-2"></i>
                Pengaturan Kontak Admin
            </h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-id-card me-2"></i>
                        Informasi Kontak Admin
                    </h5>
                    <p class="text-muted small mb-0 mt-1">
                        Data ini akan ditampilkan di halaman kontak publik
                    </p>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.contact.update') }}" method="POST" id="contactForm">
                        @csrf
                        
                        <!-- Telepon Admin -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-phone me-2"></i> Telepon Admin
                            </h6>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Nomor Telepon Admin
                                    <span class="text-danger">*</span>
                                </label>
                                
                                <!-- Single input dengan prefix tetap +62 -->
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold" style="min-width: 70px;">
                                        +62
                                    </span>
                                    <input type="text" 
                                           name="contact_phone_number" 
                                           id="contact_phone_number"
                                           class="form-control"
                                           value="{{ isset($data['contact_phone_admin']) ? preg_replace('/[^\d]/', '', substr($data['contact_phone_admin'], 3)) : '81235938380' }}"
                                           placeholder="81234629870"
                                           maxlength="14"
                                           oninput="formatPhoneInput(this, 'phone'); updatePhonePreview();">
                                    <!-- Hidden field untuk full number -->
                                    <input type="hidden" name="contact_phone_admin" id="contact_phone_full" value="{{ $data['contact_phone_admin'] ?? '+6281235938380' }}">
                                </div>
                                
                                <div class="form-text text-muted mt-2">
                                    <i class="fas fa-info-circle me-1"></i> 
                                    Cukup masukkan nomor setelah +62 (contoh: 81234629870)
                                </div>
                            </div>
                        </div>
                        
                        <!-- WhatsApp Admin -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fab fa-whatsapp me-2 text-success"></i> WhatsApp Admin
                            </h6>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Nomor WhatsApp Admin
                                    <span class="text-danger">*</span>
                                </label>
                                
                                <!-- Single input dengan prefix tetap +62 -->
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold" style="min-width: 70px;">
                                        +62
                                    </span>
                                    <input type="text" 
                                           name="contact_whatsapp_number" 
                                           id="contact_whatsapp_number"
                                           class="form-control"
                                           value="{{ isset($data['contact_whatsapp_admin']) ? preg_replace('/[^\d]/', '', substr($data['contact_whatsapp_admin'], 3)) : '81235938380' }}"
                                           placeholder="81234629870"
                                           maxlength="14"
                                           oninput="formatPhoneInput(this, 'whatsapp'); updatePhonePreview();">
                                    <!-- Hidden field untuk full number -->
                                    <input type="hidden" name="contact_whatsapp_admin" id="contact_whatsapp_full" value="{{ $data['contact_whatsapp_admin'] ?? '+6281235938380' }}">
                                </div>
                                
                                <div class="form-text text-muted mt-2">
                                    <i class="fas fa-info-circle me-1"></i> 
                                    Cukup masukkan nomor setelah +62 (contoh: 81234629870)
                                </div>
                            </div>
                            
                            <!-- Kalimat Pembuka WhatsApp -->
                            <div class="mt-4 pt-3 border-top">
                                <label class="form-label fw-semibold">
                                    Kalimat Pembuka WhatsApp
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea name="contact_whatsapp_message" 
                                          id="contact_whatsapp_message"
                                          class="form-control"
                                          rows="3"
                                          placeholder="Contoh: Halo ada yang bisa dibantu?"
                                          maxlength="200"
                                          oninput="updatePhonePreview()">{{ $data['contact_whatsapp_message'] ?? 'Halo ada yang bisa dibantu?' }}</textarea>
                                <div class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i> 
                                    Pesan yang otomatis muncul ketika customer klik tombol WhatsApp
                                </div>
                            </div>
                        </div>
                        
                        <!-- Email Admin -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-envelope me-2 text-danger"></i> Email Admin
                            </h6>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Email Admin
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       name="contact_email_admin" 
                                       id="contact_email_admin"
                                       class="form-control"
                                       value="{{ $data['contact_email_admin'] ?? 'info@umkmanda.com' }}"
                                       placeholder="contoh: admin@umkmanda.com"
                                       maxlength="100"
                                       oninput="validateEmailRealTime(); updatePhonePreview();">
                                <div class="form-text text-muted">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-info-circle me-1 mt-1"></i>
                                        <div>
                                            <span class="d-block mb-1">Pastikan format email benar:</span>
                                            <ul class="mb-0 ps-3 small">
                                                <li>Harus mengandung tanda @ (contoh: admin@domain.com)</li>
                                                <li>Harus memiliki domain (contoh: .com, .co.id, .net)</li>
                                                <li>Tidak boleh ada spasi</li>
                                                <li>Gunakan email aktif yang sering dicek</li>
                                            </ul>
                                            <div class="mt-2">
                                                <span class="fw-semibold">Format yang benar:</span>
                                                <code class="ms-2">nama@domain.com</code>
                                            </div>
                                            <div class="mt-1">
                                                <span class="fw-semibold">Format yang salah:</span>
                                                <code class="ms-2">admin domain.com</code> (tanpa @)
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Email validation preview -->
                                <div class="alert alert-light border mt-3" id="emailValidationInfo" style="display: none;">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <div>
                                            <span class="fw-semibold" id="emailStatusText"></span>
                                            <p class="mb-0 small" id="emailStatusDetail"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Alamat -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-map-marker-alt me-2 text-warning"></i> Alamat
                            </h6>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Alamat Lengkap
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea name="contact_address" 
                                          id="contact_address"
                                          class="form-control"
                                          rows="4"
                                          placeholder="Masukkan alamat lengkap"
                                          maxlength="500"
                                          oninput="updatePhonePreview()">{{ $data['contact_address'] ?? 'Jl. Prof. DR. Soepomo Sh No.29, Muja Muju, Kec. Umbulharjo, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55165' }}</textarea>
                                <div class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i> 
                                    Alamat fisik tempat usaha
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tombol Aksi -->
                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                            </a>
                            <div>
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Kolom Kanan: Preview -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-eye me-2"></i>
                        Pratinjau Kontak
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Preview Contact Section -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-2 small fw-bold">
                            <i class="fas fa-id-card me-1"></i> Tampilan Kontak Publik
                        </h6>
                        <div class="contact-preview border rounded p-4 bg-white shadow-sm">
                            <!-- Header Preview -->
                            <div class="mb-3 pb-3 border-bottom">
                                <h5 class="text-dark mb-1" style="font-weight: 600;">
                                    <i class="fas fa-headset me-2 text-primary"></i>
                                    Hubungi Kami
                                </h5>
                                <p class="small text-muted mb-0">Kami siap membantu Anda</p>
                            </div>
                            
                            <!-- Contact Info Preview -->
                            <div class="contact-items">
                                <!-- Phone -->
                                <div class="mb-3 d-flex align-items-start">
                                    <div class="contact-icon bg-light rounded-circle p-2 me-3">
                                        <i class="fas fa-phone text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 small fw-bold">Telepon</h6>
                                        <p id="phonePreview" class="mb-0 text-dark" style="font-size: 14px;">
                                            {{ $data['contact_phone_admin'] ?? '+62 812-3593-8380' }}
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- WhatsApp -->
                                <div class="mb-3 d-flex align-items-start">
                                    <div class="contact-icon bg-light rounded-circle p-2 me-3">
                                        <i class="fab fa-whatsapp text-success"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 small fw-bold">WhatsApp</h6>
                                        <p id="whatsappPreview" class="mb-0 text-dark" style="font-size: 14px;">
                                            {{ $data['contact_whatsapp_admin'] ?? '+62 812-3593-8380' }}
                                        </p>
                                        <p class="small text-muted mb-0 mt-1" id="whatsappMessagePreview">
                                            <i>Pesan: "{{ $data['contact_whatsapp_message'] ?? 'Halo ada yang bisa dibantu?' }}"</i>
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Email -->
                                <div class="mb-3 d-flex align-items-start">
                                    <div class="contact-icon bg-light rounded-circle p-2 me-3">
                                        <i class="fas fa-envelope text-danger"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 small fw-bold">Email</h6>
                                        <p id="emailPreview" class="mb-0 text-dark" style="font-size: 14px;">
                                            {{ $data['contact_email_admin'] ?? 'info@umkmanda.com' }}
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Address -->
                                <div class="mb-0 d-flex align-items-start">
                                    <div class="contact-icon bg-light rounded-circle p-2 me-3">
                                        <i class="fas fa-map-marker-alt text-warning"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 small fw-bold">Alamat</h6>
                                        <p id="addressPreview" class="mb-0 text-dark" style="font-size: 14px; line-height: 1.4;">
                                            {{ $data['contact_address'] ?? 'Jl. Prof. DR. Soepomo Sh No.29, Muja Muju, Kec. Umbulharjo, Kota Yogyakarta' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Informasi & Tips -->
                    <div class="mt-4 pt-3 border-top">
                        <h6 class="text-primary mb-2 small fw-bold">
                            <i class="fas fa-lightbulb me-1"></i> Tips & Informasi
                        </h6>
                        <div class="small text-muted">
                            <div class="d-flex align-items-start mb-2">
                                <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                <span>Pastikan nomor WhatsApp aktif</span>
                            </div>
                            <div class="d-flex align-items-start mb-2">
                                <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                <span>Kalimat WhatsApp yang ramah dan jelas</span>
                            </div>
                            <div class="d-flex align-items-start mb-2">
                                <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                <span>Alamat lengkap dengan kode pos</span>
                            </div>
                            <div class="d-flex align-items-start mb-2">
                                <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                <span>Email yang dicek secara berkala</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- WhatsApp Preview Note -->
                    <div class="mt-3 alert alert-success small">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-whatsapp fa-lg me-2 mt-1"></i>
                            <div>
                                <strong>WhatsApp Auto Message:</strong>
                                <p class="mb-0">Ketika customer klik tombol WhatsApp, pesan berikut akan otomatis muncul:</p>
                                <p class="mb-0 mt-1 fw-semibold" id="whatsappAutoMessage">
                                    "{{ $data['contact_whatsapp_message'] ?? 'Halo ada yang bisa dibantu?' }}"
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Format input nomor telepon dengan auto-format
function formatPhoneInput(input, type) {
    // Hapus semua non-digit
    let value = input.value.replace(/\D/g, '');
    
    // Batasi maksimal 11 digit (untuk nomor Indonesia)
    if (value.length > 11) {
        value = value.substring(0, 11);
    }
    
    // Format dengan dash
    let formatted = '';
    if (value.length > 0) {
        formatted = value.substring(0, 3);
        if (value.length > 3) {
            formatted += '-' + value.substring(3, 7);
        }
        if (value.length > 7) {
            formatted += '-' + value.substring(7, 11);
        }
    }
    
    // Update value di input
    input.value = formatted;
    
    // Update hidden full number field
    updateFullPhoneNumbers();
    
    return formatted;
}

// Update full phone numbers
function updateFullPhoneNumbers() {
    // Ambil nilai dari input (tanpa dash)
    const phoneNumber = document.getElementById('contact_phone_number').value.replace(/\D/g, '');
    const whatsappNumber = document.getElementById('contact_whatsapp_number').value.replace(/\D/g, '');
    
    // Update hidden fields dengan format +62
    if (phoneNumber.length >= 3) {
        document.getElementById('contact_phone_full').value = '+62' + phoneNumber;
    } else {
        document.getElementById('contact_phone_full').value = '+62';
    }
    
    if (whatsappNumber.length >= 3) {
        document.getElementById('contact_whatsapp_full').value = '+62' + whatsappNumber;
    } else {
        document.getElementById('contact_whatsapp_full').value = '+62';
    }
}

// Format number for display
function formatForDisplay(number) {
    if (!number || !number.startsWith('+62')) return '+62';
    
    const digits = number.substring(3).replace(/\D/g, '');
    if (digits.length >= 11) {
        return '+62 ' + digits.substring(0, 3) + '-' + digits.substring(3, 7) + '-' + digits.substring(7, 11);
    } else if (digits.length >= 7) {
        return '+62 ' + digits.substring(0, 3) + '-' + digits.substring(3, 7);
    } else if (digits.length >= 3) {
        return '+62 ' + digits.substring(0, 3);
    } else if (digits.length > 0) {
        return '+62' + digits;
    }
    return '+62';
}

// Email validation dengan real-time feedback
function validateEmailRealTime() {
    const emailInput = document.getElementById('contact_email_admin');
    const emailValidationInfo = document.getElementById('emailValidationInfo');
    const emailStatusText = document.getElementById('emailStatusText');
    const emailStatusDetail = document.getElementById('emailStatusDetail');
    
    if (!emailInput || !emailValidationInfo) return;
    
    const email = emailInput.value.trim();
    
    if (email === '') {
        emailValidationInfo.style.display = 'none';
        return;
    }
    
    // Basic email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const isValid = emailRegex.test(email);
    
    if (isValid) {
        // Check for common email patterns
        if (email.includes('@gmail.com') || email.includes('@yahoo.com') || 
            email.includes('@outlook.com') || email.includes('@hotmail.com')) {
            emailValidationInfo.className = 'alert alert-success border mt-3';
            emailStatusText.innerHTML = '<i class="fas fa-check-circle me-1"></i> Format email valid ✓';
            emailStatusDetail.textContent = 'Email menggunakan format yang benar dan umum digunakan.';
        } else if (email.includes('.co.id') || email.includes('.ac.id') || email.includes('.go.id')) {
            emailValidationInfo.className = 'alert alert-info border mt-3';
            emailStatusText.innerHTML = '<i class="fas fa-check-circle me-1"></i> Format email valid (Indonesia) ✓';
            emailStatusDetail.textContent = 'Email menggunakan domain Indonesia yang valid.';
        } else {
            emailValidationInfo.className = 'alert alert-success border mt-3';
            emailStatusText.innerHTML = '<i class="fas fa-check-circle me-1"></i> Format email valid ✓';
            emailStatusDetail.textContent = 'Format email sudah benar. Pastikan domain aktif.';
        }
    } else {
        emailValidationInfo.className = 'alert alert-warning border mt-3';
        emailStatusText.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i> Format email tidak valid ⚠️';
        
        // Provide specific error messages
        if (!email.includes('@')) {
            emailStatusDetail.textContent = 'Email harus mengandung tanda @ (contoh: admin@domain.com)';
        } else if (!email.includes('.')) {
            emailStatusDetail.textContent = 'Email harus memiliki domain (contoh: .com, .co.id)';
        } else if (email.includes(' ')) {
            emailStatusDetail.textContent = 'Email tidak boleh mengandung spasi';
        } else {
            emailStatusDetail.textContent = 'Format email tidak sesuai standar. Gunakan format: nama@domain.com';
        }
    }
    
    emailValidationInfo.style.display = 'block';
}

// Update semua preview
function updatePhonePreview() {
    updateFullPhoneNumbers();
    
    // Phone preview
    const phoneFull = document.getElementById('contact_phone_full').value;
    const phonePreview = document.getElementById('phonePreview');
    if (phonePreview) {
        phonePreview.textContent = phoneFull ? formatForDisplay(phoneFull) : '+62 812-3593-8380';
    }
    
    // WhatsApp preview
    const whatsappFull = document.getElementById('contact_whatsapp_full').value;
    const whatsappPreview = document.getElementById('whatsappPreview');
    if (whatsappPreview) {
        whatsappPreview.textContent = whatsappFull ? formatForDisplay(whatsappFull) : '+62 812-3593-8380';
    }
    
    // WhatsApp message preview
    const whatsappMessageInput = document.getElementById('contact_whatsapp_message');
    const whatsappMessagePreview = document.getElementById('whatsappMessagePreview');
    const whatsappAutoMessage = document.getElementById('whatsappAutoMessage');
    if (whatsappMessageInput) {
        const message = whatsappMessageInput.value || 'Halo ada yang bisa dibantu?';
        if (whatsappMessagePreview) {
            whatsappMessagePreview.innerHTML = `<i>Pesan: "${message}"</i>`;
        }
        if (whatsappAutoMessage) {
            whatsappAutoMessage.textContent = `"${message}"`;
        }
    }
    
    // Email preview
    const emailInput = document.getElementById('contact_email_admin');
    const emailPreview = document.getElementById('emailPreview');
    if (emailPreview && emailInput) {
        emailPreview.textContent = emailInput.value || 'info@umkmanda.com';
    }
    
    // Address preview
    const addressInput = document.getElementById('contact_address');
    const addressPreview = document.getElementById('addressPreview');
    if (addressPreview && addressInput) {
        addressPreview.textContent = addressInput.value || 'Jl. Prof. DR. Soepomo Sh No.29, Muja Muju, Kec. Umbulharjo, Kota Yogyakarta';
    }
}

// Show toast notification dengan opsi HTML
function showToast(icon, title, text = '', timer = 3000, html = '') {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: timer,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    
    const options = {
        icon: icon,
        title: title
    };
    
    if (html) {
        options.html = html;
    } else if (text) {
        options.text = text;
    }
    
    Toast.fire(options);
}

// Email validation function
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Form validation dengan notifikasi SweetAlert2 hanya di kanan atas
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent default untuk validasi client-side
    
    let isValid = true;
    const errors = [];
    
    // Validate phone - harus 11 digit setelah +62
    const phoneNumber = document.getElementById('contact_phone_number').value.replace(/\D/g, '');
    
    if (!phoneNumber.trim()) {
        errors.push('Nomor telepon admin harus diisi');
    } else if (phoneNumber.length < 11) {
        errors.push('Nomor telepon harus 11 digit (contoh: 81234629870)');
    }
    
    // Validate WhatsApp - harus 11 digit setelah +62
    const whatsappNumber = document.getElementById('contact_whatsapp_number').value.replace(/\D/g, '');
    
    if (!whatsappNumber.trim()) {
        errors.push('Nomor WhatsApp admin harus diisi');
    } else if (whatsappNumber.length < 11) {
        errors.push('Nomor WhatsApp harus 11 digit (contoh: 81234629870)');
    }
    
    // Validate WhatsApp message
    const whatsappMessageInput = document.getElementById('contact_whatsapp_message');
    if (whatsappMessageInput && !whatsappMessageInput.value.trim()) {
        errors.push('Kalimat pembuka WhatsApp harus diisi');
    }
    
    // Validate email
    const emailInput = document.getElementById('contact_email_admin');
    if (emailInput && !emailInput.value.trim()) {
        errors.push('Email admin harus diisi');
    } else if (emailInput && !isValidEmail(emailInput.value)) {
        errors.push('Format email tidak valid. Pastikan menggunakan format: nama@domain.com');
    }
    
    // Validate address
    const addressInput = document.getElementById('contact_address');
    if (addressInput && !addressInput.value.trim()) {
        errors.push('Alamat harus diisi');
    }
    
    if (errors.length > 0) {
        // Show error notification di kanan atas SAJA
        let errorMessage = '';
        if (errors.length === 1) {
            errorMessage = errors[0];
        } else {
            errorMessage = errors.map((error, index) => `${index + 1}. ${error}`).join('<br>');
        }
        
        showToast('error', 'Validasi Gagal', errorMessage, 5000);
        
        // TIDAK ADA modal lagi, hanya toast di kanan atas
    } else {
        // Show loading notification di kanan atas
        Swal.fire({
            title: 'Menyimpan...',
            text: 'Mohon tunggu sebentar',
            icon: 'info',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            }
        }).then(() => {
            // Submit form setelah loading selesai
            this.submit();
        });
    }
});

// Check for success message from server (if redirected back with success)
document.addEventListener('DOMContentLoaded', function() {
    console.log('Contact settings page loaded');
    
    // Format phone numbers on load
    const phoneInput = document.getElementById('contact_phone_number');
    const whatsappInput = document.getElementById('contact_whatsapp_number');
    
    if (phoneInput) {
        formatPhoneInput(phoneInput, 'phone');
    }
    
    if (whatsappInput) {
        formatPhoneInput(whatsappInput, 'whatsapp');
    }
    
    // Set initial preview
    updatePhonePreview();
    
    // Validate email on load
    validateEmailRealTime();
    
    // Add animation to preview
    const previewElement = document.querySelector('.contact-preview');
    if (previewElement) {
        previewElement.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';
        });
        
        previewElement.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    }
    
    // Auto-focus ke input pertama
    if (phoneInput) {
        phoneInput.focus();
    }
    
    // Check for session messages (Laravel session)
    @if(session('success'))
        setTimeout(() => {
            showToast('success', 'Berhasil!', '{{ session('success') }}', 4000);
        }, 500);
    @endif
    
    @if(session('error'))
        setTimeout(() => {
            showToast('error', 'Gagal!', '{{ session('error') }}', 5000);
        }, 500);
    @endif
    
    // Check URL for success parameter (alternative method)
    const urlParams = new URLSearchParams(window.location.search);
    const successParam = urlParams.get('success');
    
    if (successParam === 'true') {
        setTimeout(() => {
            showToast('success', 'Berhasil!', 'Pengaturan kontak admin berhasil diperbarui.', 4000);
        }, 500);
    } else if (successParam === 'false') {
        setTimeout(() => {
            showToast('error', 'Gagal!', 'Terjadi kesalahan saat menyimpan pengaturan.', 5000);
        }, 500);
    }
});

// Reset form (optional - jika nanti mau ditambahkan tombol reset)
function resetContactForm() {
    Swal.fire({
        title: 'Reset Form?',
        text: 'Semua perubahan yang belum disimpan akan hilang.',
        icon: 'question',
        toast: true,
        position: 'top-end',
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya, Reset',
        cancelButtonText: 'Batal',
        timer: 10000,
        timerProgressBar: true,
        reverseButtons: true,
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('contactForm').reset();
            
            // Reset hidden fields
            document.getElementById('contact_phone_full').value = '+6281235938380';
            document.getElementById('contact_whatsapp_full').value = '+6281235938380';
            
            // Set default values untuk input
            document.getElementById('contact_phone_number').value = '812-3593-8380';
            document.getElementById('contact_whatsapp_number').value = '812-3593-8380';
            document.getElementById('contact_whatsapp_message').value = 'Halo ada yang bisa dibantu?';
            document.getElementById('contact_email_admin').value = 'info@umkmanda.com';
            document.getElementById('contact_address').value = 'Jl. Prof. DR. Soepomo Sh No.29, Muja Muju, Kec. Umbulharjo, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55165';
            
            // Reset preview
            updatePhonePreview();
            validateEmailRealTime();
            
            // Show success toast
            showToast('success', 'Form direset!', 'Form telah dikembalikan ke nilai default.', 2000);
        }
    });
}
</script>

<style>
.card {
    border-radius: 16px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.05);
}

.card-header {
    background: linear-gradient(135deg, #fdfdfd 0%, #f8f9fa 100%);
    font-weight: 600;
    border-bottom: 1px solid #e6e6e6;
    border-radius: 16px 16px 0 0 !important;
}

.form-control {
    border-radius: 12px;
    border: 1px solid #ced4da;
    padding: 12px 16px;
    background: #fafafa;
    transition: .25s;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.form-control:hover {
    background: #fff;
    border-color: #b1b1b1;
}

.form-control:focus {
    border-color: #4CAF50;
    box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, .25);
}

/* Styling untuk input group */
.input-group {
    border-radius: 12px;
    overflow: hidden;
}

.input-group-text {
    font-weight: 700;
    color: #2c3e50;
    background-color: #f8f9fa;
    border: 1px solid #ced4da;
    border-right: 1px solid #dee2e6 !important;
    min-width: 70px;
    justify-content: center;
    border-radius: 12px 0 0 12px !important;
}

.input-group .form-control {
    border-left: none;
    border-radius: 0 12px 12px 0 !important;
}

.btn-success {
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    padding: 10px 26px;
    border-radius: 12px;
    transition: .25s;
    border: none;
    font-weight: 600;
}

.btn-success:hover {
    background: linear-gradient(135deg, #45a049 0%, #3d8b40 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
}

.btn-outline-secondary {
    border-radius: 12px;
    font-weight: 600;
    transition: .25s;
}

.btn-outline-secondary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.contact-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
}

.contact-preview {
    transition: all 0.3s;
    border-radius: 16px;
}

.contact-preview .border-bottom {
    border-bottom: 1px solid #eaeaea !important;
}

.contact-preview .border-top {
    border-top: 1px solid #eaeaea !important;
}

.alert-success {
    background: linear-gradient(135deg, #e8f7ef 0%, #d4f0e0 100%);
    border-left: 4px solid #4CAF50;
    border-radius: 12px;
    border: none;
}

.alert-info {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    border-left: 4px solid #2196F3;
    border-radius: 12px;
    border: none;
}

.alert-warning {
    background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
    border-left: 4px solid #ff9800;
    border-radius: 12px;
    border: none;
}

.alert-light {
    background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
    border-left: 4px solid #9e9e9e;
    border-radius: 12px;
    border: 1px solid #e0e0e0 !important;
}

/* Format khusus untuk input nomor telepon */
input[name="contact_phone_number"],
input[name="contact_whatsapp_number"] {
    font-weight: 700;
    letter-spacing: 0.5px;
    font-family: 'Courier New', monospace;
}

/* Textarea styling */
textarea.form-control {
    border-radius: 12px;
    min-height: 120px;
    resize: vertical;
}

/* Preview section styling */
.badge {
    border-radius: 6px;
}

.border {
    border: 1px solid #e6e6e6 !important;
    border-radius: 16px;
}

.border-top {
    border-top: 1px solid #eaeaea !important;
}

.border-bottom {
    border-bottom: 1px solid #eaeaea !important;
}

/* Card shadow dan border radius tambahan */
.sticky-top {
    border-radius: 16px;
}

.shadow-sm {
    box-shadow: 0 2px 8px rgba(0,0,0,0.08) !important;
}

/* Input focus state dengan rounded corners */
.form-control:focus {
    border-radius: 12px;
}

/* SweetAlert2 Toast Customization */
.swal2-popup {
    border-radius: 12px !important;
}

.swal2-toast {
    border-radius: 8px !important;
    font-size: 14px !important;
    padding: 12px 20px !important;
}

.swal2-toast.swal2-success {
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%) !important;
    color: white !important;
}

.swal2-toast.swal2-error {
    background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%) !important;
    color: white !important;
}

.swal2-toast.swal2-warning {
    background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%) !important;
    color: white !important;
}

.swal2-toast.swal2-info {
    background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%) !important;
    color: white !important;
}

.swal2-toast.swal2-question {
    background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%) !important;
    color: white !important;
}

/* Animations for SweetAlert */
.animate__animated {
    animation-duration: 0.3s;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card {
        margin-bottom: 20px;
        border-radius: 14px;
    }
    
    .contact-preview {
        padding: 15px !important;
        border-radius: 14px;
    }
    
    .contact-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
    }
    
    .d-flex.gap-2 {
        flex-direction: column;
        gap: 10px !important;
    }
    
    .input-group-text {
        min-width: 60px;
        font-size: 0.9rem;
        border-radius: 10px 0 0 10px !important;
    }
    
    .input-group .form-control {
        border-radius: 0 10px 10px 0 !important;
    }
    
    .btn-success, .btn-outline-secondary {
        width: 100%;
        margin-bottom: 10px;
        border-radius: 10px;
    }
    
    .form-control {
        border-radius: 10px;
    }
    
    textarea.form-control {
        border-radius: 10px;
    }
    
    .alert-success, .alert-info, .alert-warning, .alert-light {
        border-radius: 10px;
    }
    
    /* Toast responsive */
    .swal2-toast {
        width: 90% !important;
        margin: 10px auto !important;
        left: 5% !important;
        right: 5% !important;
    }
    
    /* Email validation info responsive */
    .form-text ul {
        padding-left: 15px !important;
    }
    
    .form-text code {
        font-size: 0.8rem;
    }
}
</style>
@endsection