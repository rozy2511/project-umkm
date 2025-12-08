@extends('admin.layouts.main')

@section('title', 'Pengaturan Logo & Favicon')

@section('content')
<div class="container-fluid py-2">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h1 class="h3 mb-4 text-gray-800">
                <i class="fas fa-image text-primary mr-2"></i>
                Manage Logo & Favicon
            </h1>
        </div>
    </div>
    <div class="row">
        <!-- Kolom Kiri: Form Edit -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-palette me-2"></i>
                        Edit Logo & Favicon Website
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.logo.update') }}" method="POST" enctype="multipart/form-data" id="logoForm">
                        @csrf
                        
                        {{-- Hidden input untuk logo_type --}}
                        <input type="hidden" name="logo_type" id="logoTypeInput" value="{{ $data['logo_type'] ?? 'image' }}">

                        <!-- Opsi Logo: Text atau Gambar -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-flag me-2"></i> Logo Utama Website
                            </h6>
                            
                            {{-- Pilih Tipe Logo Sederhana --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold mb-3">Pilih Tipe Logo</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="logo_type_radio" 
                                               id="logoTypeImageRadio" 
                                               value="image"
                                               {{ ($data['logo_type'] ?? 'image') == 'image' ? 'checked' : '' }}
                                               onchange="toggleLogoType('image')">
                                        <label class="form-check-label" for="logoTypeImageRadio">
                                            <i class="fas fa-image me-1"></i> Logo Gambar
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="logo_type_radio" 
                                               id="logoTypeTextRadio" 
                                               value="text"
                                               {{ ($data['logo_type'] ?? 'image') == 'text' ? 'checked' : '' }}
                                               onchange="toggleLogoType('text')">
                                        <label class="form-check-label" for="logoTypeTextRadio">
                                            <i class="fas fa-font me-1"></i> Logo Teks
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Logo Gambar Options --}}
                            <div id="logoImageOptions" style="{{ ($data['logo_type'] ?? 'image') == 'image' ? '' : 'display: none;' }}">
                                {{-- Preview Saat Ini --}}
                                @if($data['website_logo'])
                                <div class="mb-3 p-3 border rounded bg-light">
                                    <p class="small text-muted mb-2">Logo Gambar Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $data['website_logo']) }}" 
                                         alt="Current Logo" 
                                         class="img-fluid mb-2" 
                                         style="max-height: 80px;">
                                    <p class="small mb-0">
                                        <code>{{ basename($data['website_logo']) }}</code>
                                    </p>
                                </div>
                                @endif
                                
                                <div class="file-upload-area">
                                    <div class="mb-3">
                                        <input type="file" 
                                               name="website_logo" 
                                               id="website_logo" 
                                               class="form-control"
                                               accept=".jpg,.jpeg,.png,.svg,.webp"
                                               onchange="previewLogoImage(event)">
                                        <div class="form-text text-muted">
                                            <i class="fas fa-info-circle me-1"></i> 
                                            Format: JPG, PNG, SVG, WEBP | Maks: 2MB
                                        </div>
                                    </div>
                                    
                                    @if($data['website_logo'])
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="delete_website_logo" 
                                               id="delete_website_logo" 
                                               value="1">
                                        <label class="form-check-label text-danger" for="delete_website_logo">
                                            <i class="fas fa-trash-alt me-1"></i> Hapus logo gambar saat ini
                                        </label>
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-text">
                                            <i class="fas fa-lightbulb text-warning me-1"></i>
                                            <strong>Rekomendasi:</strong>
                                        </div>
                                        <ul class="small text-muted mb-0">
                                            <li>Ukuran: 300×100px</li>
                                            <li>Format: PNG dengan transparansi</li>
                                            <li>Warna: Sesuai branding</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-text">
                                            <i class="fas fa-exclamation-triangle text-danger me-1"></i>
                                            <strong>Hindari:</strong>
                                        </div>
                                        <ul class="small text-muted mb-0">
                                            <li>Logo terlalu besar (≤2MB)</li>
                                            <li>Background warna putih polos</li>
                                            <li>Format BMP atau TIFF</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Logo Text Options --}}
                            <div id="logoTextOptions" style="{{ ($data['logo_type'] ?? 'image') == 'text' ? '' : 'display: none;' }}">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Teks Logo</label>
                                    <input type="text" 
                                           name="logo_text" 
                                           id="logo_text"
                                           class="form-control"
                                           value="{{ $data['logo_text'] ?? $data['site_title'] ?? 'UMKM Shop' }}"
                                           placeholder="Masukkan teks untuk logo"
                                           maxlength="50"
                                           oninput="updateTextLogoPreview()">
                                    <div class="form-text text-muted">
                                        <i class="fas fa-info-circle me-1"></i> 
                                        Teks yang akan ditampilkan sebagai logo
                                    </div>
                                </div>
                            </div>
                        </div>
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        <!-- Favicon -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-star me-2"></i> Favicon Website
                            </h6>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Favicon (Ikon Browser)</label>
                                
                                {{-- WARNING FAVICON HARUS .ICO --}}
                                <div class="alert alert-warning mb-3">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-exclamation-triangle fa-lg me-3 mt-1 text-warning"></i>
                                        <div>
                                            <strong class="d-block mb-1">Favicon harus format .ICO untuk tampilan optimal!</strong>
                                            <small class="text-dark">
                                                • Convert PNG/JPG ke .ico di: 
                                                <a href="https://favicon.io/favicon-converter/" target="_blank" class="fw-bold text-decoration-underline">favicon.io</a><br>
                                                • Ukuran direkomendasikan: 64×64px atau 32×32px<br>
                                                • Format .ico akan tampil bundar di browser tab
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($data['website_favicon'])
                                <div class="mb-3 p-3 border rounded bg-light">
                                    <p class="small text-muted mb-2">Favicon Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $data['website_favicon']) }}" 
                                         alt="Current Favicon" 
                                         class="mb-2 favicon-current" 
                                         style="width: 32px; height: 32px;">
                                    <p class="small mb-0">
                                        <code>{{ basename($data['website_favicon']) }}</code>
                                    </p>
                                </div>
                                @endif
                                
                                <div class="file-upload-area">
                                    <div class="mb-3">
                                        <input type="file" 
                                               name="website_favicon" 
                                               id="website_favicon" 
                                               class="form-control"
                                               accept=".ico,.png,.jpg,.jpeg,.svg"
                                               onchange="previewFavicon(event)">
                                        <div class="form-text text-muted">
                                            <i class="fas fa-info-circle me-1"></i> 
                                            Format: <strong class="text-success">.ICO</strong>, PNG, JPG, SVG | Maks: 1MB
                                            <span class="badge bg-success ms-2">.ICO Direkomendasikan</span>
                                        </div>
                                    </div>
                                    
                                    @if($data['website_favicon'])
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="delete_website_favicon" 
                                               id="delete_website_favicon" 
                                               value="1">
                                        <label class="form-check-label text-danger" for="delete_website_favicon">
                                            <i class="fas fa-trash-alt me-1"></i> Hapus favicon saat ini
                                        </label>
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="alert alert-info mt-3">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-lightbulb fa-lg me-3 mt-1 text-info"></i>
                                        <div>
                                            <strong>Tips Favicon:</strong>
                                            <ul class="mb-0 mt-1 small">
                                                <li>Buat favicon 64×64px atau 32×32px</li>
                                                <li>ICO format direkomendasikan untuk kompatibilitas browser terbaik</li>
                                                <li>Gunakan tool online gratis untuk convert ke .ico</li>
                                                <li>Test di berbagai browser setelah upload</li>
                                            </ul>
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
                        Pratinjau Tampilan
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Ringkasan Status -->
                    <div class="alert alert-light border mb-4">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="small text-muted">Status Konfigurasi:</span>
                            <span class="badge bg-success">Aktif</span>
                        </div>
                        <div class="small text-muted">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Tipe Logo:</span>
                                <span class="{{ ($data['logo_type'] ?? 'image') == 'text' ? 'text-info' : 'text-success' }}">
                                    {{ ($data['logo_type'] ?? 'image') == 'text' ? 'Teks' : 'Gambar' }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Status Favicon:</span>
                                <span class="{{ $data['website_favicon'] ? 'text-success' : 'text-warning' }}">
                                    {{ $data['website_favicon'] ? '✓ Terpasang' : '✗ Belum ada' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Browser Tab -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-2 small fw-bold">
                            <i class="fas fa-window-maximize me-1"></i> Browser Tab
                        </h6>
                        <div class="browser-tab-preview border rounded bg-light p-2 mb-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="favicon-container me-2">
                                        <img id="previewFaviconLive" 
                                             src="{{ $data['website_favicon'] ? asset('storage/' . $data['website_favicon']) : 'https://via.placeholder.com/16x16/2196F3/fff?text=F' }}" 
                                             width="16" 
                                             height="16" 
                                             class="rounded-circle border shadow-sm">
                                    </div>
                                    <div class="site-name">
                                        <span class="small fw-medium">
                                            @if(($data['logo_type'] ?? 'image') == 'text')
                                                {{ Str::limit($data['logo_text'] ?? $data['site_title'] ?? 'UMKM Shop', 20) }}
                                            @else
                                                {{ Str::limit(config('app.name', 'UMKM Website'), 20) }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="tab-controls">
                                    <span class="text-muted me-2" style="font-size: 12px;">–</span>
                                    <span class="text-muted me-2" style="font-size: 12px;">□</span>
                                    <span class="text-muted" style="font-size: 12px;">×</span>
                                </div>
                            </div>
                        </div>
                        <p class="small text-muted mb-0">
                            <i class="fas fa-info-circle me-1"></i> 
                            Favicon muncul di tab browser, bookmark, dan history.
                        </p>
                    </div>

                    <!-- Preview Header Website -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-2 small fw-bold">
                            <i class="fas fa-header me-1"></i> Header Website
                        </h6>
                        <div class="header-preview border rounded p-3 bg-white shadow-sm">
                            <!-- Simulated Navigation Bar -->
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div id="headerLogoPreview" class="logo-container">
                                    @if(($data['logo_type'] ?? 'image') == 'text')
                                        <span style="
                                            font-family: Arial, sans-serif;
                                            color: #000000;
                                            font-size: 24px;
                                            font-weight: bold;
                                            letter-spacing: 0.5px;
                                        ">
                                            {{ $data['logo_text'] ?? $data['site_title'] ?? 'UMKM Shop' }}
                                        </span>
                                    @else
                                        @if($data['website_logo'])
                                            <img id="previewLogoLive" 
                                                 src="{{ asset('storage/' . $data['website_logo']) }}" 
                                                 alt="Logo" 
                                                 style="height: 40px; max-width: 200px; object-fit: contain;">
                                        @else
                                            <img src="https://via.placeholder.com/120x40/4CAF50/fff?text=LOGO+HERE" 
                                                 alt="Logo" 
                                                 style="height: 40px; max-width: 200px; object-fit: contain;">
                                        @endif
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Navigation Menu -->
                            <div class="nav-menu-preview">
                                <div class="d-flex justify-content-between border-top pt-3">
                                    <div>
                                        <a href="#" class="text-decoration-none small me-3 text-dark">
                                            <i class="fas fa-home me-1"></i> Beranda
                                        </a>
                                        <a href="#" class="text-decoration-none small me-3 text-dark">
                                            <i class="fas fa-store me-1"></i> Produk
                                        </a>
                                        <a href="#" class="text-decoration-none small me-3 text-dark">
                                            <i class="fas fa-info-circle me-1"></i> Tentang
                                        </a>
                                        <a href="#" class="text-decoration-none small text-dark">
                                            <i class="fas fa-envelope me-1"></i> Kontak
                                        </a>
                                    </div>
                                    <div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 d-flex justify-content-between align-items-center">
                            <p class="small text-muted mb-0">
                                <i class="fas fa-info-circle me-1"></i> 
                                Logo muncul di semua halaman website.
                            </p>
                            <span class="badge bg-light text-dark small">Header</span>
                        </div>
                    </div>

                    <!-- Preview Mobile View -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-2 small fw-bold">
                            <i class="fas fa-mobile-alt me-1"></i> Tampilan Mobile
                        </h6>
                        <div class="mobile-preview border rounded bg-light p-3">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="mobile-logo">
                                    @if(($data['logo_type'] ?? 'image') == 'text')
                                        <span style="
                                            font-family: Arial, sans-serif;
                                            color: #000000;
                                            font-size: 18px;
                                            font-weight: bold;
                                        ">
                                            {{ Str::limit($data['logo_text'] ?? $data['site_title'] ?? 'UMKM', 12) }}
                                        </span>
                                    @else
                                        <img src="{{ $data['website_logo'] ? asset('storage/' . $data['website_logo']) : 'https://via.placeholder.com/80x30/4CAF50/fff?text=LOGO' }}" 
                                             alt="Logo Mobile" 
                                             style="height: 30px; max-width: 100px;">
                                    @endif
                                </div>
                                <div class="mobile-menu-icon">
                                    <span class="text-dark">☰</span>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="bg-white rounded p-2 mb-2 small">
                                    Konten website akan muncul di sini
                                </div>
                            </div>
                        </div>
                        <p class="small text-muted mb-0 mt-2">
                            <i class="fas fa-info-circle me-1"></i> 
                            Logo akan menyesuaikan ukuran pada perangkat mobile.
                        </p>
                    </div>

                    <!-- Informasi & Tips -->
                    <div class="mt-4 pt-3 border-top">
                        <h6 class="text-primary mb-2 small fw-bold">
                            <i class="fas fa-lightbulb me-1"></i> Tips & Informasi
                        </h6>
                        <div class="small text-muted">
                            <div class="d-flex align-items-start mb-2">
                                <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                <span>Logo teks lebih cepat loading dan SEO friendly</span>
                            </div>
                            <div class="d-flex align-items-start mb-2">
                                <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                <span>Logo gambar lebih visual dan profesional</span>
                            </div>
                            <div class="d-flex align-items-start mb-2">
                                <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                <span>Favicon .ICO kompatibel dengan semua browser</span>
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
function toggleLogoType(type) {
    document.getElementById('logoTypeInput').value = type;
    
    if (type === 'image') {
        document.getElementById('logoImageOptions').style.display = 'block';
        document.getElementById('logoTextOptions').style.display = 'none';
        updateHeaderPreview();
    } else {
        document.getElementById('logoImageOptions').style.display = 'none';
        document.getElementById('logoTextOptions').style.display = 'block';
        updateTextLogoPreview();
    }
}

// Update preview logo teks
function updateTextLogoPreview() {
    const textInput = document.getElementById('logo_text');
    
    // VALIDASI: Pastikan element ada
    if (!textInput) {
        console.log('Element tidak ditemukan');
        return;
    }
    
    const text = textInput.value;
    
    // Update text preview
    const preview = document.getElementById('textLogoPreview');
    if (preview) {
        preview.textContent = text;
    }
    
    // Update header preview
    updateHeaderPreview();
    
    // Update mobile preview
    const mobilePreview = document.querySelector('.mobile-logo span');
    if (mobilePreview) {
        mobilePreview.textContent = text.length > 12 ? text.substring(0, 12) + '...' : text;
    }
}

// Update header preview untuk gambar
function updateHeaderPreview() {
    const logoType = document.getElementById('logoTypeInput');
    const headerPreview = document.getElementById('headerLogoPreview');
    const logoInput = document.getElementById('website_logo');
    
    if (!logoType || !headerPreview) return;
    
    if (logoType.value === 'text') {
        const textInput = document.getElementById('logo_text');
        
        if (!textInput) return;
        
        const text = textInput.value;
        
        headerPreview.innerHTML = `
            <span style="
                color: #000000; 
                font-size: 24px; 
                font-weight: bold;
                letter-spacing: 0.5px;
            ">
                ${text}
            </span>
        `;
        
        // Update mobile text preview
        const mobileLogo = document.querySelector('.mobile-logo');
        if (mobileLogo) {
            mobileLogo.innerHTML = `
                <span style="
                    color: #000000; 
                    font-size: 18px; 
                    font-weight: bold;
                ">
                    ${text.length > 12 ? text.substring(0, 12) + '...' : text}
                </span>
            `;
        }
    } else {
        if (logoInput && logoInput.files && logoInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                headerPreview.innerHTML = `<img src="${e.target.result}" alt="Logo" style="height: 40px; max-width: 200px; object-fit: contain;">`;
                
                // Update mobile image preview
                const mobileLogo = document.querySelector('.mobile-logo');
                if (mobileLogo) {
                    mobileLogo.innerHTML = `<img src="${e.target.result}" alt="Logo Mobile" style="height: 30px; max-width: 100px;">`;
                }
            };
            reader.readAsDataURL(logoInput.files[0]);
        } else {
            // Jika tidak ada file baru, gunakan gambar yang ada
            const currentLogo = '{{ $data["website_logo"] ? asset("storage/" . $data["website_logo"]) : "https://via.placeholder.com/120x40/4CAF50/fff?text=LOGO+HERE" }}';
            headerPreview.innerHTML = `<img src="${currentLogo}" alt="Logo" style="height: 40px; max-width: 200px; object-fit: contain;">`;
            
            // Update mobile image preview
            const mobileLogo = document.querySelector('.mobile-logo');
            if (mobileLogo) {
                mobileLogo.innerHTML = `<img src="${currentLogo}" alt="Logo Mobile" style="height: 30px; max-width: 100px;">`;
            }
        }
    }
}

// Preview logo gambar
function previewLogoImage(event) {
    const input = event.target;
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
        updateHeaderPreview();
    }
}

// Preview favicon
function previewFavicon(event) {
    const input = event.target;
    const preview = document.getElementById('previewFaviconLive');
    
    if (!preview) return;
    
    if (input.files && input.files[0]) {
        // Validate file size
        if (input.files[0].size > 1 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'File Terlalu Besar',
                text: 'Ukuran file maksimal 1MB.',
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
            preview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Reset form
function resetForm() {
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
            document.getElementById('logoForm').reset();
            
            // Reset checkboxes
            document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
            
            // Reset to original type
            const originalType = '{{ $data["logo_type"] ?? "image" }}';
            toggleLogoType(originalType);
            
            // Reset text preview
            if (originalType === 'text') {
                document.getElementById('logo_text').value = '{{ $data["logo_text"] ?? $data["site_title"] ?? "UMKM Shop" }}';
                updateTextLogoPreview();
            }
            
            // Reset favicon preview
            const faviconPreview = document.getElementById('previewFaviconLive');
            if (faviconPreview) {
                faviconPreview.src = '{{ $data["website_favicon"] ? asset("storage/" . $data["website_favicon"]) : "https://via.placeholder.com/16x16/2196F3/fff?text=F" }}';
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
document.getElementById('logoForm').addEventListener('submit', function(e) {
    let isValid = true;
    const logoType = document.getElementById('logoTypeInput');
    
    if (!logoType) return;
    
    if (logoType.value === 'text') {
        const logoText = document.getElementById('logo_text');
        if (logoText && !logoText.value.trim()) {
            Swal.fire({
                icon: 'error',
                title: 'Teks Logo Kosong',
                text: 'Harap isi teks logo untuk tipe logo teks.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            isValid = false;
        }
    }
    
    // Validate file sizes
    const fileInputs = [
        { id: 'website_logo', maxSize: 2048, name: 'Logo Gambar' },
        { id: 'website_favicon', maxSize: 1024, name: 'Favicon' }
    ];
    
    fileInputs.forEach(fileInput => {
        const input = document.getElementById(fileInput.id);
        if (input && input.files.length > 0) {
            const file = input.files[0];
            if (file.size > fileInput.maxSize * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Terlalu Besar',
                    text: `${fileInput.name} terlalu besar! Maksimal ${fileInput.maxSize}KB.`,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                isValid = false;
            }
        }
    });
    
    if (!isValid) {
        e.preventDefault();
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Logo page loaded');
    
    // Set initial preview based on logo type
    const logoType = '{{ $data["logo_type"] ?? "image" }}';
    
    // Tunggu sebentar agar DOM sepenuhnya terload
    setTimeout(() => {
        if (logoType === 'text') {
            updateTextLogoPreview();
        }
    }, 100);
    
    // Add animation to previews
    const previewElements = document.querySelectorAll('.browser-tab-preview, .header-preview, .mobile-preview');
    previewElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';
        });
        
        element.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    });
});
</script>

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

.preview-content {
    line-height: 1.7;
}

.browser-tab-preview {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    transition: all 0.3s;
}

.header-preview {
    transition: all 0.3s;
}

.mobile-preview {
    background: #f8f9fa;
    transition: all 0.3s;
}

.alert-info {
    background: linear-gradient(135deg, #e8f4fd 0%, #d4e9fb 100%);
    border-left: 4px solid #2196F3;
    border-radius: 6px;
}

.alert-warning {
    background: linear-gradient(135deg, #fff8e1 0%, #fff3cd 100%);
    border-left: 4px solid #ff9800;
    border-radius: 6px;
}

.form-check-input:checked {
    background-color: #4CAF50;
    border-color: #4CAF50;
}

/* Favicon styling */
.favicon-container img {
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.favicon-current {
    border-radius: 50%;
    object-fit: cover;
    border: 1px solid #dee2e6;
}

.badge.bg-success {
    font-size: 0.7em;
    padding: 0.2em 0.6em;
}

/* Logo container */
.logo-container {
    padding: 5px 0;
}

/* Navigation preview */
.nav-menu-preview a {
    transition: color 0.2s;
}

.nav-menu-preview a:hover {
    color: #7b3f00 !important;
}

/* Mobile preview styling */
.mobile-menu-icon {
    font-size: 24px;
    cursor: pointer;
}

/* Status styling */
.status-logo-type, .status-favicon {
    font-weight: 600;
    font-size: 0.85em;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card {
        margin-bottom: 20px;
    }
    
    .header-preview .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
    }
    
    .header-preview .nav-menu-preview {
        margin-top: 15px;
    }
}
</style>
@endsection