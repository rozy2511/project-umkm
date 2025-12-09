@extends('admin.layouts.main')

@section('title', 'Pengaturan SEO')

@section('content')
<div class="container-fluid py-2">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h1 class="h3 mb-4 text-gray-800">
                <i class="fas fa-search text-primary mr-2"></i>
                SEO & Title Website
            </h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-cogs me-2"></i>
                        Edit SEO & Title Website
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.settings.seo.update') }}" id="seoForm">
                        @csrf
                        
                        <!-- Site Title -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-heading me-2"></i> Judul Website
                            </h6>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Judul Utama (Title)</label>
                                <div class="input-group">
                                    <input type="text" 
                                           name="site_title" 
                                           id="site_title"
                                           class="form-control"
                                           value="{{ $data['site_title'] ?? 'UMKM Shop' }}"
                                           placeholder="Contoh: UMKM Jajan Pasar - Produk Lokal Terbaik"
                                           maxlength="70"
                                           oninput="updateSeoPreview()">
                                    <span class="input-group-text">
                                        <span id="titleCounter">{{ strlen($data['site_title'] ?? 'UMKM Shop') }}</span>/70
                                    </span>
                                </div>
                                <div class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i> 
                                    Judul yang muncul di Google dan tab browser. Maksimal 70 karakter.
                                </div>
                            </div>
                        </div>
                        
                        <!-- Meta Description -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-align-left me-2"></i> Deskripsi Website
                            </h6>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Deskripsi (Meta Description)</label>
                                <div class="input-group">
                                    <textarea name="site_description" 
                                              id="site_description"
                                              class="form-control"
                                              rows="3"
                                              placeholder="Contoh: Toko online UMKM dengan produk lokal berkualitas. Belanja aman, cepat, dan terpercaya."
                                              maxlength="160"
                                              oninput="updateSeoPreview()">{{ $data['site_description'] ?? '' }}</textarea>
                                    <span class="input-group-text">
                                        <span id="descCounter">{{ strlen($data['site_description'] ?? '') }}</span>/160
                                    </span>
                                </div>
                                <div class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i> 
                                    Deskripsi singkat yang muncul di hasil pencarian Google. Maksimal 160 karakter.
                                </div>
                            </div>
                        </div>
                        
                        <!-- Meta Keywords -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-key me-2"></i> Kata Kunci
                            </h6>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kata Kunci (Keywords)</label>
                                <input type="text" 
                                       name="site_keywords" 
                                       id="site_keywords"
                                       class="form-control"
                                       value="{{ $data['site_keywords'] ?? '' }}"
                                       placeholder="Contoh: umkm, produk lokal, jajan pasar, makanan tradisional, oleh-oleh khas">
                                <div class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i> 
                                    Pisahkan dengan koma. Gunakan kata kunci yang sering dicari oleh pelanggan.
                                </div>
                            </div>
                        </div>
                        
                        <!-- Meta Author -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-user me-2"></i> Author/Pembuat
                            </h6>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Author/Pembuat Website</label>
                                <input type="text" 
                                       name="meta_author" 
                                       id="meta_author"
                                       class="form-control"
                                       value="{{ $data['meta_author'] ?? '' }}"
                                       placeholder="Contoh: Tim UMKM Jajan Pasar">
                                <div class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i> 
                                    Menambah kredibilitas website di mata Google.
                                </div>
                            </div>
                        </div>
                        
                        <!-- Meta Robots -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-robot me-2"></i> Instruksi Mesin Pencari
                            </h6>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Meta Robots</label>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                   type="radio" 
                                                   name="meta_robots" 
                                                   id="index_follow" 
                                                   value="index,follow"
                                                   {{ ($data['meta_robots'] ?? 'index,follow') == 'index,follow' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="index_follow">
                                                <strong>Index & Follow</strong><br>
                                                <small class="text-muted">Tampilkan di Google dan ikuti semua link</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                   type="radio" 
                                                   name="meta_robots" 
                                                   id="noindex_nofollow" 
                                                   value="noindex,nofollow"
                                                   {{ ($data['meta_robots'] ?? '') == 'noindex,nofollow' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="noindex_nofollow">
                                                <strong>Noindex & Nofollow</strong><br>
                                                <small class="text-muted">Jangan tampilkan di Google</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-warning mt-3">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-exclamation-triangle fa-lg me-3 mt-1 text-warning"></i>
                                        <div>
                                            <strong>Peringatan!</strong> Pilih "Noindex & Nofollow" hanya untuk website testing atau yang tidak ingin ditampilkan di Google.
                                        </div>
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
                        Pratinjau SEO
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Google Preview -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-2 small fw-bold">
                            <i class="fab fa-google me-1"></i> Tampilan di Google
                        </h6>
                        <div class="google-preview border rounded p-3 bg-white shadow-sm">
                            <div class="mb-2">
                                <div id="previewTitle" class="text-primary fw-bold" style="
                                    font-size: 18px;
                                    line-height: 1.3;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                    white-space: nowrap;
                                ">
                                    {{ $data['site_title'] ?? 'UMKM Shop' }}
                                </div>
                                <div class="text-success small mb-2">
                                    <i class="fas fa-link me-1"></i>
                                    {{ request()->getSchemeAndHttpHost() }}
                                </div>
                                <div id="previewDescription" class="text-muted small" style="
                                    font-size: 14px;
                                    line-height: 1.5;
                                ">
                                    {{ $data['site_description'] ?? 'Website UMKM Terpercaya' }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 d-flex justify-content-between align-items-center">
                            <p class="small text-muted mb-0">
                                <i class="fas fa-info-circle me-1"></i> 
                                Preview hasil pencarian Google
                            </p>
                            <span class="badge bg-light text-dark small">Google</span>
                        </div>
                    </div>
                    
                    <!-- SEO Tips -->
                    <div class="mt-4 pt-3 border-top">
                        <h6 class="text-primary mb-2 small fw-bold">
                            <i class="fas fa-lightbulb me-1"></i> Tips SEO Terbaik
                        </h6>
                        <div class="small text-muted">
                            <div class="d-flex align-items-start mb-2">
                                <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                <span>Judul 50-60 karakter (optimal)</span>
                            </div>
                            <div class="d-flex align-items-start mb-2">
                                <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                <span>Deskripsi 120-150 karakter</span>
                            </div>
                            <div class="d-flex align-items-start mb-2">
                                <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                <span>Gunakan kata kunci relevan</span>
                            </div>
                            <div class="d-flex align-items-start mb-2">
                                <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                <span>Selalu pilih "Index & Follow"</span>
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
// Update character counters and preview
function updateSeoPreview() {
    const titleInput = document.getElementById('site_title');
    const descInput = document.getElementById('site_description');
    
    // Update counters
    if (titleInput) {
        document.getElementById('titleCounter').textContent = titleInput.value.length;
    }
    
    if (descInput) {
        document.getElementById('descCounter').textContent = descInput.value.length;
    }
    
    // Update preview
    const previewTitle = document.getElementById('previewTitle');
    const previewDesc = document.getElementById('previewDescription');
    
    if (titleInput && previewTitle) {
        previewTitle.textContent = titleInput.value || 'UMKM Shop';
    }
    
    if (descInput && previewDesc) {
        previewDesc.textContent = descInput.value || 'Website UMKM Terpercaya';
    }
}

// Form validation
document.getElementById('seoForm').addEventListener('submit', function(e) {
    const title = document.getElementById('site_title').value.trim();
    const desc = document.getElementById('site_description').value.trim();
    const keywords = document.getElementById('site_keywords').value.trim();
    const author = document.getElementById('meta_author').value.trim();
    
    if (!title || !desc || !keywords || !author) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Form Tidak Lengkap',
            text: 'Harap isi semua field yang wajib diisi.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        return false;
    }
    
    // Validate title length
    if (title.length > 70) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Judul Terlalu Panjang',
            text: 'Judul maksimal 70 karakter.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        return false;
    }
    
    // Validate description length
    if (desc.length > 160) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Deskripsi Terlalu Panjang',
            text: 'Deskripsi maksimal 160 karakter.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        return false;
    }
    
    return true;
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateSeoPreview();
    
    // Add animation to preview
    const previewElement = document.querySelector('.google-preview');
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
    background: #fff;
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

.alert-warning {
    background: linear-gradient(135deg, #fff8e1 0%, #ffe0b2 100%);
    border-left: 4px solid #ff9800;
    border-radius: 6px;
}

.google-preview {
    transition: all 0.3s;
    font-family: Arial, sans-serif;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card {
        margin-bottom: 20px;
    }
    
    .google-preview {
        padding: 15px !important;
    }
    
    #previewTitle {
        font-size: 16px !important;
    }
}
</style>
@endsection