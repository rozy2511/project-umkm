@extends('admin.layouts.main')

@section('title', 'Pengaturan Welcome Message')

@section('content')
<div class="container-fluid py-2">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h1 class="h3 mb-4 text-gray-800">
                <i class="fas fa-home text-primary mr-2"></i>
                Welcome Message
            </h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-comment-alt me-2"></i>
                        Edit Welcome Message
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.welcome.update') }}" method="POST" enctype="multipart/form-data" id="welcomeForm">
                        @csrf
                        
                        <!-- Welcome Title -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-heading me-2"></i> Judul Welcome
                            </h6>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Judul Utama</label>
                                <input type="text" 
                                       name="welcome_title" 
                                       id="welcome_title"
                                       class="form-control"
                                       value="{{ $data['welcome_title'] ?? 'Selamat Datang di UMKM Kami' }}"
                                       placeholder="Masukkan judul welcome message"
                                       maxlength="100"
                                       oninput="updateWelcomePreview()">
                                <div class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i> 
                                    Judul yang muncul di bagian atas halaman beranda
                                </div>
                            </div>
                        </div>
                        
                        <!-- Welcome Subtitle -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-paragraph me-2"></i> Subtitle Welcome
                            </h6>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Deskripsi/Kalimat Pembuka</label>
                                <textarea name="welcome_subtitle" 
                                          id="welcome_subtitle"
                                          class="form-control"
                                          rows="3"
                                          placeholder="Masukkan kalimat pembuka atau deskripsi singkat"
                                          maxlength="200"
                                          oninput="updateWelcomePreview()">{{ $data['welcome_subtitle'] ?? 'Produk berkualitas dari tangan lokal' }}</textarea>
                                <div class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i> 
                                    Kalimat pembuka yang muncul di bawah judul
                                </div>
                            </div>
                        </div>
                        
                        <!-- Welcome Image -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-image me-2"></i> Gambar Welcome (Optional)
                            </h6>
                            
                            {{-- Preview Saat Ini --}}
                            @if($data['welcome_image'])
                            <div class="mb-3 p-3 border rounded bg-light">
                                <p class="small text-muted mb-2">Gambar Saat Ini:</p>
                                <img src="{{ asset('storage/' . $data['welcome_image']) }}" 
                                     alt="Current Welcome Image" 
                                     class="img-fluid rounded mb-2" 
                                     style="max-height: 150px;">
                                <p class="small mb-0">
                                    <code>{{ basename($data['welcome_image']) }}</code>
                                </p>
                            </div>
                            @endif
                            
                            <div class="file-upload-area">
                                <div class="mb-3">
                                    <input type="file" 
                                           name="welcome_image" 
                                           id="welcome_image" 
                                           class="form-control"
                                           accept=".jpg,.jpeg,.png,.webp"
                                           onchange="previewWelcomeImage(event)">
                                    <div class="form-text text-muted">
                                        <i class="fas fa-info-circle me-1"></i> 
                                        Format: JPG, PNG, WEBP | Maks: 2MB
                                    </div>
                                </div>
                                
                                @if($data['welcome_image'])
                                <div class="form-check mb-3">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="delete_welcome_image" 
                                           id="delete_welcome_image" 
                                           value="1">
                                    <label class="form-check-label text-danger" for="delete_welcome_image">
                                        <i class="fas fa-trash-alt me-1"></i> Hapus gambar saat ini
                                    </label>
                                </div>
                                @endif
                            </div>
                            
                            <div class="alert alert-info mt-3">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-lightbulb fa-lg me-3 mt-1 text-info"></i>
                                    <div>
                                        <strong>Tips Gambar Welcome:</strong>
                                        <ul class="mb-0 mt-1 small">
                                            <li>Ukuran direkomendasikan: 1200×400px</li>
                                            <li>Gambar landscape (mendatar) lebih baik</li>
                                            <li>Warna cerah untuk menarik perhatian</li>
                                            <li>Kualitas tinggi tanpa blur</li>
                                        </ul>
                                    </div>
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
                        Pratinjau Welcome Message
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Preview Welcome Message -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-2 small fw-bold">
                            <i class="fas fa-home me-1"></i> Tampilan Beranda
                        </h6>
                        <div class="welcome-preview border rounded p-4 bg-white shadow-sm">
                            <!-- Hero Section Preview -->
                            <div class="hero-preview mb-3" id="welcomeHeroPreview">
                                @if($data['welcome_image'])
                                <div class="welcome-image-preview mb-3 rounded overflow-hidden" style="height: 150px; background: #f8f9fa;">
                                    <img src="{{ asset('storage/' . $data['welcome_image']) }}" 
                                         alt="Welcome Image" 
                                         class="img-fluid w-100 h-100 object-fit-cover">
                                </div>
                                @endif
                                
                                <div class="welcome-content text-center">
                                    <h2 id="welcomeTitlePreview" class="mb-3" style="
                                        color: #2c3e50; 
                                        font-weight: 700; 
                                        font-size: 32px;
                                    ">
                                        {{ $data['welcome_title'] ?? 'Selamat Datang di UMKM Kami' }}
                                    </h2>
                                    
                                    <p id="welcomeSubtitlePreview" class="lead mb-4" style="
                                        color: #555; 
                                        font-size: 18px;
                                        line-height: 1.6;
                                    ">
                                        {{ $data['welcome_subtitle'] ?? 'Produk berkualitas dari tangan lokal' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 d-flex justify-content-between align-items-center">
                            <p class="small text-muted mb-0">
                                <i class="fas fa-info-circle me-1"></i> 
                                Tampilan welcome message di halaman beranda
                            </p>
                            <span class="badge bg-light text-dark small">Beranda</span>
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
                                <span>Judul yang singkat dan menarik perhatian</span>
                            </div>
                            <div class="d-flex align-items-start mb-2">
                                <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                <span>Subtitle yang menjelaskan value proposition</span>
                            </div>
                            <div class="d-flex align-items-start mb-2">
                                <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                <span>Gambar welcome memperkuat branding</span>
                            </div>
                            <div class="d-flex align-items-start mb-2">
                                <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                <span>Konsisten dengan tema warna website</span>
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
// Update welcome preview
function updateWelcomePreview() {
    const titleInput = document.getElementById('welcome_title');
    const subtitleInput = document.getElementById('welcome_subtitle');
    
    // Update title preview
    const titlePreview = document.getElementById('welcomeTitlePreview');
    if (titlePreview && titleInput) {
        titlePreview.textContent = titleInput.value || 'Selamat Datang di UMKM Kami';
    }
    
    // Update subtitle preview
    const subtitlePreview = document.getElementById('welcomeSubtitlePreview');
    if (subtitlePreview && subtitleInput) {
        subtitlePreview.textContent = subtitleInput.value || 'Produk berkualitas dari tangan lokal';
    }
}

// Preview welcome image
function previewWelcomeImage(event) {
    const input = event.target;
    const preview = document.querySelector('.welcome-image-preview');
    
    if (!preview) {
        // Create preview container if not exists
        const heroPreview = document.getElementById('welcomeHeroPreview');
        if (heroPreview) {
            const newPreview = document.createElement('div');
            newPreview.className = 'welcome-image-preview mb-3 rounded overflow-hidden';
            newPreview.style.height = '150px';
            newPreview.style.background = '#f8f9fa';
            
            const img = document.createElement('img');
            img.className = 'img-fluid w-100 h-100 object-fit-cover';
            img.alt = 'Welcome Image';
            
            newPreview.appendChild(img);
            heroPreview.insertBefore(newPreview, heroPreview.firstChild);
        }
    }
    
    if (input.files && input.files[0]) {
        // Validate file size
        if (input.files[0].size > 2 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'File Terlalu Besar',
                text: 'Ukuran file maksimal 2MB.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.querySelector('.welcome-image-preview img');
            if (img) {
                img.src = e.target.result;
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Reset form
function resetWelcomeForm() {
    Swal.fire({
        title: 'Reset Perubahan?',
        text: 'Semua perubahan yang belum disimpan akan hilang.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Reset',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('welcomeForm').reset();
            
            // Reset checkboxes
            document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
            
            // Reset preview
            updateWelcomePreview();
            
            // Remove image preview if exists
            const imagePreview = document.querySelector('.welcome-image-preview');
            if (imagePreview) {
                imagePreview.remove();
            }
            
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Form telah direset ke keadaan awal.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
}

// Form validation
document.getElementById('welcomeForm').addEventListener('submit', function(e) {
    let isValid = true;
    
    // Validate title
    const titleInput = document.getElementById('welcome_title');
    if (titleInput && !titleInput.value.trim()) {
        Swal.fire({
            icon: 'error',
            title: 'Judul Welcome Kosong',
            text: 'Harap isi judul welcome message.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        isValid = false;
    }
    
    // Validate subtitle
    const subtitleInput = document.getElementById('welcome_subtitle');
    if (subtitleInput && !subtitleInput.value.trim()) {
        Swal.fire({
            icon: 'error',
            title: 'Subtitle Welcome Kosong',
            text: 'Harap isi subtitle welcome message.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        isValid = false;
    }
    
    // Validate file size if image uploaded
    const imageInput = document.getElementById('welcome_image');
    if (imageInput && imageInput.files.length > 0) {
        const file = imageInput.files[0];
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'File Terlalu Besar',
                text: 'Ukuran file maksimal 2MB.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            isValid = false;
        }
    }
    
    if (!isValid) {
        e.preventDefault();
    }
});

// SweetAlert2 Notification setelah save berhasil - SAMA SEPERTI LOCATION PAGE
document.addEventListener('DOMContentLoaded', function() {
    console.log('Welcome settings page loaded');
    
    // Set initial preview
    updateWelcomePreview();
    
    // Add animation to preview
    const previewElement = document.querySelector('.welcome-preview');
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
});
</script>

{{-- NOTIFICATION TOAST SCRIPT --}}
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session("success") }}',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session("error") }}',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500
    });
</script>
@endif

<style>
.card {
    border-radius: 12px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.05);
}

.card-header {
    background: linear-gradient(135deg, #fdfdfd 0%, #f8f9fa 100%);
    font-weight: 600;
    border-bottom: 1px solid #e6e6e6;
}

.form-control {
    border-radius: 8px;
    border: 1px solid #ced4da;
    padding: 12px 16px;
    background: #fafafa;
    transition: .25s;
}

.form-control:hover {
    background: #fff;
}

.form-control:focus {
    border-color: #4CAF50;
    box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, .25);
}

.btn-success {
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    padding: 10px 26px;
    border-radius: 8px;
    transition: .25s;
    border: none;
}

.btn-success:hover {
    background: linear-gradient(135deg, #45a049 0%, #3d8b40 100%);
    transform: translateY(-1px);
}

.file-upload-area {
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 20px;
    background: #f8f9fa;
    transition: all 0.3s;
}

.file-upload-area:hover {
    border-color: #4CAF50;
    background: #f0fff0;
}

.welcome-preview {
    transition: all 0.3s;
}

.alert-info {
    background: linear-gradient(135deg, #e8f4fd 0%, #d4e9fb 100%);
    border-left: 4px solid #2196F3;
    border-radius: 6px;
}

.object-fit-cover {
    object-fit: cover;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card {
        margin-bottom: 20px;
    }
    
    .welcome-preview {
        padding: 15px !important;
    }
    
    #welcomeTitlePreview {
        font-size: 24px !important;
    }
    
    #welcomeSubtitlePreview {
        font-size: 16px !important;
    }
}
</style>
@endsection