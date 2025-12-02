@extends('admin.layouts.main')

@section('content')
<div class="container-fluid px-4">
    <!-- Flash Messages - iPhone Style Popup -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
        @if(session('success'))
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white border-0" style="border-radius: 10px 10px 0 0;">
                <i class="fas fa-check-circle me-2"></i>
                <strong class="me-auto">Sukses</strong>
                <small>baru saja</small>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body bg-light" style="border-radius: 0 0 10px 10px;">
                {{ session('success') }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger text-white border-0" style="border-radius: 10px 10px 0 0;">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong class="me-auto">Error</strong>
                <small>baru saja</small>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body bg-light" style="border-radius: 0 0 10px 10px;">
                {{ session('error') }}
            </div>
        </div>
        @endif
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Produk Baru</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Produk</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" 
                                       placeholder="Masukkan nama produk" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price') }}" 
                                           placeholder="0" min="0" required>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Produk <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Deskripsikan produk Anda..." required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail Produk <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" 
                                   id="thumbnail" name="thumbnail" accept="image/*" required>
                            <div class="form-text">Format: JPEG, PNG, JPG. Maksimal 2MB</div>
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Gallery Images -->
<div class="mb-3">
    <label for="gallery" class="form-label">Foto Produk (Gallery) <span class="text-danger">*</span></label>
    <input type="file" 
           class="form-control @error('gallery.*') is-invalid @enderror @error('gallery') is-invalid @enderror" 
           id="gallery" 
           name="gallery[]" 
           accept="image/*"
           multiple
           required>
    <div class="form-text">
        <i class="fas fa-info-circle text-primary me-1"></i>
        Minimal 2 foto, maksimal 7 foto. Format: JPEG, PNG, JPG. Maksimal 2MB per foto.
    </div>
    
    <!-- Preview Gallery -->
    <div id="gallery-preview" class="row mt-3 g-2 d-none">
        <!-- Preview akan muncul di sini -->
    </div>

    @error('gallery')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @error('gallery.*')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

                        {{-- TOGGLE TOP PRODUCT --}}
                       <div class="mb-6 p-4 bg-amber-50 rounded-lg border border-amber-200">
    <div class="flex items-center">
        <input type="checkbox" name="is_top" id="is_top" value="1" 
               {{ old('is_top') ? 'checked' : '' }}
               class="w-4 h-4 text-amber-600 bg-gray-100 border-gray-300 rounded focus:ring-amber-500 focus:ring-2">
        <label for="is_top" class="ml-3 text-sm font-medium text-amber-800">
             Jadikan Produk TOP 
            <span class="text-amber-600 text-xs block">(Produk akan muncul di urutan atas dengan badge spesial)</span>
        </label>
    </div>
</div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Produk
                            </button>
                            
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Status</small>
                        <div class="fw-bold">
                            <span class="badge bg-info">Baru</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">ID Produk</small>
                        <div class="fw-bold text-muted">-</div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Slug</small>
                        <div class="fw-bold text-muted">-</div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Akan dibuat</small>
                        <div class="fw-bold">
                            <span id="currentTimeInfo"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Waktu Server</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div id="currentTime" class="h5 mb-2 text-primary"></div>
                        <div id="currentDate" class="text-muted small"></div>
                    </div>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Panduan</h6>
                </div>
                <div class="card-body">
                    <div class="small text-muted">
                        <div class="mb-2">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            <strong>Nama produk</strong> akan otomatis generate slug
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            <strong>Harga</strong> dalam Rupiah tanpa titik
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            <strong>Gambar</strong> akan di-compress otomatis
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 10px;
}
.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}
.input-group-text {
    background-color: #f8f9fa;
    border-color: #ced4da;
}
.bg-amber-50 {
    background-color: #fffbeb;
}
.border-amber-200 {
    border-color: #fcd34d;
}
.text-amber-800 {
    color: #92400e;
}
.w-4 {
    width: 1rem;
}
.h-4 {
    height: 1rem;
}
</style>

<script>
// Initialize toast notifications
document.addEventListener('DOMContentLoaded', function() {
    const toasts = document.querySelectorAll('.toast');
    
    toasts.forEach(toast => {
        // Show toast
        toast.classList.add('show');
        
        // Auto hide setelah 4 detik
        setTimeout(() => {
            toast.classList.add('hide');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 4000);
        
        // Close button manual
        const closeBtn = toast.querySelector('.btn-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                toast.classList.add('hide');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            });
        }
    });

    // Real-time Indonesia Clock dengan hari Bahasa Indonesia
    function updateIndonesiaTime() {
        const now = new Date();
        
        const hariIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        const hari = hariIndo[now.getDay()];
        const tanggal = now.getDate();
        const bulan = bulanIndo[now.getMonth()];
        const tahun = now.getFullYear();
        
        const jam = now.getHours().toString().padStart(2, '0');
        const menit = now.getMinutes().toString().padStart(2, '0');
        const detik = now.getSeconds().toString().padStart(2, '0');
        
        // Update waktu server
        document.getElementById('currentTime').textContent = `${jam}:${menit}:${detik} WIB`;
        document.getElementById('currentDate').textContent = `${hari}, ${tanggal} ${bulan} ${tahun}`;
        
        // Update info waktu pembuatan
        document.getElementById('currentTimeInfo').textContent = `Sekarang - ${jam}:${menit} WIB`;
    }

    // Update immediately and every second
    updateIndonesiaTime();
    setInterval(updateIndonesiaTime, 1000);
});
</script>
@endsection