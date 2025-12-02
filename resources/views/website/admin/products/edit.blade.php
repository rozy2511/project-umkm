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
        <h1 class="h3 mb-0 text-gray-800">Edit Produk</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Produk</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf
                        @method('PUT')

                        <!-- Input harga asli (hidden) -->
                        <input type="hidden" name="price" id="price_actual" value="{{ old('price', $product->price) }}">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $product->name) }}" 
                                       placeholder="Masukkan nama produk" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="price_display" class="form-label">Harga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control @error('price') is-invalid @enderror" 
                                           id="price_display" 
                                           value="{{ old('price', number_format($product->price, 0, ',', '.')) }}" 
                                           placeholder="1.000" required>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Produk</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Deskripsikan produk Anda...">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar Produk</label>
                            
                            <!-- Current Image -->
                            <div class="mb-3">
                                <label class="form-label text-muted">Thumbnail Saat Ini</label>
                                <div class="border rounded p-3 text-center bg-light">
                                    @if($product->thumbnail)
                                        <img src="{{ asset('storage/' . $product->thumbnail) }}" 
                                             alt="{{ $product->name }}" 
                                             class="img-fluid rounded mb-2" 
                                             style="max-height: 200px;">
                                        <div class="text-muted small">
                                            {{ basename($product->thumbnail) }}
                                        </div>
                                    @else
                                        <div class="text-muted py-4">
                                            <i class="fas fa-image fa-2x mb-2"></i>
                                            <div>Tidak ada gambar</div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- New Image Upload -->
                            <div>
                                <label for="thumbnail" class="form-label">Ganti Thumbnail <small class="text-muted">(Opsional)</small></label>
                                <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" 
                                       id="thumbnail" name="thumbnail" accept="image/*">
                                <div class="form-text">Format: JPEG, PNG, JPG. Maksimal 2MB</div>
                                @error('thumbnail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- TOGGLE TOP PRODUCT --}}
                        <div class="mb-3 p-3 bg-amber-50 rounded-lg border border-amber-200">
                            <div class="form-check">
                                <input type="checkbox" name="is_top" id="is_top" value="1" 
                                       class="form-check-input" 
                                       {{ old('is_top', $product->is_top) ? 'checked' : '' }}>
                                <label for="is_top" class="form-check-label text-amber-800 fw-medium">
                                    Jadikan Produk TOP 
                                    <span class="d-block text-amber-600 small">(Produk akan muncul di urutan atas dengan badge spesial)</span>
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Produk
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
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Produk</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">ID Produk</small>
                        <div class="fw-bold">{{ $product->id }}</div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Slug</small>
                        <div class="fw-bold">
                            <code class="bg-light px-2 py-1 rounded">{{ $product->slug }}</code>
                        </div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Dibuat</small>
                        <div class="fw-bold">
                            @php
                                $hariIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                                $bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                
                                $created = $product->created_at->timezone('Asia/Jakarta');
                                $hari = $hariIndo[$created->dayOfWeek];
                                $tanggal = $created->format('d');
                                $bulan = $bulanIndo[$created->month - 1];
                                $tahun = $created->format('Y');
                            @endphp
                            {{ $hari }}, {{ $tanggal }} {{ $bulan }} {{ $tahun }}<br>
                            <small class="text-muted">Pukul {{ $created->format('H:i') }} WIB</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Diperbarui</small>
                        <div class="fw-bold">
                            @php
                                $updated = $product->updated_at->timezone('Asia/Jakarta');
                                $hari = $hariIndo[$updated->dayOfWeek];
                                $tanggal = $updated->format('d');
                                $bulan = $bulanIndo[$updated->month - 1];
                                $tahun = $updated->format('Y');
                            @endphp
                            {{ $hari }}, {{ $tanggal }} {{ $bulan }} {{ $tahun }}<br>
                            <small class="text-muted">Pukul {{ $updated->format('H:i') }} WIB</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Status</small>
                        <div class="fw-bold">
                            <span class="badge bg-success">Aktif</span>
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
                    <h6 class="m-0 font-weight-bold text-primary">Preview</h6>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('products.show', $product->slug) }}" 
                       target="_blank" 
                       class="btn btn-outline-info btn-sm w-100 mb-2">
                        <i class="fas fa-external-link-alt me-2"></i>Lihat di Website
                    </a>
                    <small class="text-muted">Buka di tab baru</small>
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize toast notifications
    const toasts = document.querySelectorAll('.toast');
    
    toasts.forEach(toast => {
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.add('hide');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 4000);
        
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

    // Real-time Indonesia Clock
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
        
        document.getElementById('currentTime').textContent = `${jam}:${menit}:${detik} WIB`;
        document.getElementById('currentDate').textContent = `${hari}, ${tanggal} ${bulan} ${tahun}`;
    }

    updateIndonesiaTime();
    setInterval(updateIndonesiaTime, 1000);

    // Format Harga dengan titik pemisah ribuan
    const priceDisplay = document.getElementById('price_display');
    const priceActual = document.getElementById('price_actual');
    const productForm = document.getElementById('productForm');

    // Format tampilan harga saat input
    priceDisplay.addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^\d]/g, '');
        
        if (value) {
            // Update input tersembunyi dengan angka murni
            priceActual.value = parseInt(value) || 0;
            
            // Format tampilan dengan titik pemisah ribuan
            e.target.value = parseInt(value).toLocaleString('id-ID');
        } else {
            priceActual.value = '';
            e.target.value = '';
        }
    });

    // Format harga saat halaman dimuat
    if (priceDisplay.value) {
        let value = priceDisplay.value.replace(/[^\d]/g, '');
        if (value) {
            priceDisplay.value = parseInt(value).toLocaleString('id-ID');
        }
    }

    // Format harga sebelum submit form
    productForm.addEventListener('submit', function(e) {
        // Pastikan nilai yang dikirim adalah angka murni
        let value = priceDisplay.value.replace(/[^\d]/g, '');
        priceActual.value = value || 0;
    });

    // Fungsi bantu untuk menghapus format
    function removeFormatting(value) {
        return value.toString().replace(/[^\d]/g, '');
    }
});
</script>
@endsection
