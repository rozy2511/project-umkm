@extends('admin.layouts.main')

@section('content')
<div class="container-fluid px-4">
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
                            <textarea class="form-control summernote @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar Produk</label>
                            
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

                        <div class="mb-3">
                            <label class="form-label">Foto Produk (Gallery)</label>
                            
                            @if($product->galleries && $product->galleries->count() > 0)
                            <div class="mb-3">
                                <label class="form-label text-muted">Gallery Saat Ini</label>
                                <div class="row g-2">
                                    @foreach($product->galleries as $gallery)
                                    <div class="col-md-3 col-6">
                                        <div class="border rounded p-2 position-relative">
                                            <img src="{{ asset('storage/' . $gallery->image_path) }}" 
                                                 class="img-fluid rounded mb-1"
                                                 style="height: 100px; width: 100%; object-fit: cover;">
                                            <div class="text-center">
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger btn-remove-gallery"
                                                        data-id="{{ $gallery->id }}">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @else
                            <div class="alert alert-info mb-3">
                                <i class="fas fa-info-circle me-2"></i>
                                Belum ada foto gallery untuk produk ini.
                            </div>
                            @endif

                            <div>
                                <label for="gallery" class="form-label">Tambah Foto Gallery <small class="text-muted">(Opsional)</small></label>
                                <input type="file" 
                                       class="form-control @error('gallery.*') is-invalid @enderror" 
                                       id="gallery" 
                                       name="gallery[]" 
                                       accept="image/*"
                                       multiple>
                                <div class="form-text">
                                    Maksimal 7 foto total. Format: JPEG, PNG, JPG. Maksimal 2MB per foto.
                                </div>
                                
                                <div id="gallery-preview" class="row mt-3 g-2 d-none">
                                </div>
                            </div>
                            
                            @error('gallery.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 p-3 bg-amber-50 rounded-lg border border-amber-200">
                            <div class="form-check">
                                <input type="checkbox" name="is_top" id="is_top" value="1" 
                                       class="form-check-input" 
                                       {{ old('is_top', $product->is_top) ? 'checked' : '' }}>
                                <label for="is_top" class="form-check-label text-amber-800 fw-medium">
                                    Jadikan Produk TOP 
                                    <span class="d-block text-amber-600 small">(Produk akan muncul di urutan atas)</span>
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
.bg-amber-50 {
    background-color: #fffbeb;
}
.border-amber-200 {
    border-color: #fcd34d;
}
.text-amber-800 {
    color: #92400e;
}
.note-editor.note-frame {
    border: 1px solid #dee2e6 !important;
    border-radius: 0.375rem !important;
    margin-top: 5px;
}
.note-toolbar {
    background-color: #f8f9fa !important;
    border-bottom: 1px solid #dee2e6 !important;
    padding: 0.4rem !important;
    border-radius: 0.375rem 0.375rem 0 0 !important;
    min-height: 40px !important;
}
.note-btn-group {
    margin-right: 3px !important;
}
.note-btn {
    padding: 0.25rem 0.5rem !important;
    font-size: 0.875rem !important;
}
.note-editable {
    min-height: 120px !important;
    padding: 12px !important;
    font-size: 0.95rem;
}
.note-statusbar {
    height: 25px !important;
}
.note-placeholder {
    padding: 12px !important;
    font-size: 0.95rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
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

    const priceDisplay = document.getElementById('price_display');
    const priceActual = document.getElementById('price_actual');
    const productForm = document.getElementById('productForm');

    if (priceDisplay) {
        priceDisplay.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^\d]/g, '');
            
            if (value) {
                priceActual.value = parseInt(value) || 0;
                e.target.value = parseInt(value).toLocaleString('id-ID');
            } else {
                priceActual.value = '';
                e.target.value = '';
            }
        });

        if (priceDisplay.value) {
            let value = priceDisplay.value.replace(/[^\d]/g, '');
            if (value) {
                priceDisplay.value = parseInt(value).toLocaleString('id-ID');
            }
        }
    }

    if (productForm) {
        productForm.addEventListener('submit', function(e) {
            if (priceDisplay) {
                let value = priceDisplay.value.replace(/[^\d]/g, '');
                priceActual.value = value || 0;
            }
        });
    }

    const galleryInput = document.getElementById('gallery');
    if (galleryInput) {
        galleryInput.addEventListener('change', function(e) {
            const previewContainer = document.getElementById('gallery-preview');
            if (previewContainer) {
                previewContainer.innerHTML = '';
                previewContainer.classList.remove('d-none');
                
                const files = e.target.files;
                if (files && files.length > 0) {
                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        const reader = new FileReader();
                        
                        reader.onload = function(event) {
                            const col = document.createElement('div');
                            col.className = 'col-md-3 col-6 mb-2';
                            
                            col.innerHTML = `
                                <div class="border rounded p-1">
                                    <img src="${event.target.result}" 
                                         class="img-fluid rounded"
                                         style="height: 80px; width: 100%; object-fit: cover;">
                                    <div class="text-center small text-muted">
                                        Foto ${i + 1}
                                    </div>
                                </div>
                            `;
                            
                            previewContainer.appendChild(col);
                        };
                        
                        reader.readAsDataURL(file);
                    }
                }
            }
        });
    }

    const removeButtons = document.querySelectorAll('.btn-remove-gallery');
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const galleryId = this.getAttribute('data-id');
            const currentCount = document.querySelectorAll('.btn-remove-gallery').length;
            
            if (currentCount <= 1) {
                alert('Minimal harus ada 1 foto gallery');
                return;
            }
            
            if (confirm('Hapus foto ini?')) {
                this.closest('.col-md-3').remove();
                
                let deleteInput = document.getElementById('delete_galleries');
                if (!deleteInput) {
                    deleteInput = document.createElement('input');
                    deleteInput.type = 'hidden';
                    deleteInput.name = 'delete_galleries[]';
                    deleteInput.id = 'delete_galleries';
                    document.getElementById('productForm').appendChild(deleteInput);
                }
                
                const currentValue = deleteInput.value ? deleteInput.value.split(',') : [];
                if (!currentValue.includes(galleryId)) {
                    currentValue.push(galleryId);
                    deleteInput.value = currentValue.join(',');
                }
            }
        });
    });

    if ($('.summernote').length > 0) {
        $('.summernote').summernote({
            height: 200,
            lang: 'id-ID',
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol']],
            ],
            placeholder: 'Deskripsikan produk Anda...',
            callbacks: {
                onImageUpload: function(files) {
                    uploadSummernoteImage(files[0]);
                }
            }
        });
    }

    function uploadSummernoteImage(file) {
        const formData = new FormData();
        formData.append('image', file);
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch('/admin/upload-editor-image', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Upload gagal');
            }
            return response.json();
        })
        .then(data => {
            if (data.url) {
                $('.summernote').summernote('insertImage', data.url);
            }
        })
        .catch(error => {
            console.error('Error uploading image:', error);
            alert('Gagal mengupload gambar. Pastikan ukuran file maksimal 2MB.');
        });
    }
});
</script>
@endsection