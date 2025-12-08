@extends('admin.layouts.main')

@section('title', 'Pengaturan Lokasi & Jam Operasional')

@section('content')
<div class="container-fluid py-2">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h1 class="h3 mb-4 text-gray-800">
                <i class="fas fa-share-alt text-primary mr-2"></i>
                Manage Jam Operasional & Lokasi
            </h1>
        </div>
    </div>
    <div class="row">
        <!-- Kolom Kiri: Form Edit -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Edit Lokasi & Jam Operasional
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.location.update') }}" method="POST">
                        @csrf

                        <!-- Informasi Kontak -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-info-circle me-2"></i> Informasi Lokasi Dan Jam Operasional
                            </h6>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Alamat Lengkap</label>
                                <textarea name="company_address" class="form-control"
                                          rows="3" placeholder="Masukkan alamat lengkap usaha Anda" required>{{ old('company_address', $address) }}</textarea>
                                @error('company_address')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Google Maps -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-map me-2"></i> Peta Lokasi (Google Maps)
                            </h6>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kode Embed Google Maps</label>
                                <textarea name="google_maps_embed" 
                                          class="form-control font-monospace" 
                                          rows="8" 
                                          placeholder="Tempel kode embed dari Google Maps di sini" 
                                          required>{{ old('google_maps_embed', $maps_embed) }}</textarea>
                                <div class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i> Cara mendapatkan: Buka Google Maps → Cari lokasi Anda → Klik "Share" → Pilih "Embed a map" → Copy kode HTML
                                </div>
                                @error('google_maps_embed')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Jam Operasional -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-clock me-2"></i> Jam Operasional
                            </h6>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Deskripsi Jam Operasional</label>
                                <textarea name="operational_description" 
                                          class="form-control" 
                                          rows="4"
                                          id="opDescInput"
                                          placeholder="Deskripsikan jam operasional usaha Anda" required>{{ old('operational_description', $op_desc) }}</textarea>
                                <div class="form-text text-muted">
                                    <i class="fas fa-lightbulb me-1"></i> Format sederhana:
                                    <br>• <code>*teks*</code> = <strong>tebal</strong>
                                    <br>• <code>_teks_</code> = <em>miring</em>
                                    <br>• Enter untuk baris baru
                                </div>
                                @error('operational_description')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Catatan Tambahan</label>
                                <textarea name="operational_notes" 
                                          class="form-control" 
                                          rows="5"
                                          id="opNotesInput"
                                          placeholder="Tambahkan catatan penting untuk pelanggan" required>{{ old('operational_notes', $op_notes) }}</textarea>
                                <div class="form-text text-muted">
                                    <pre class="mt-1 small">
- Datang pagi untuk menu lengkap
- Stok _terbatas_, cepat habis
- Layanan pesan antar tersedia</pre>
                                </div>
                                @error('operational_notes')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                            </a>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
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
                        Pratinjau Tampilan Publik
                    </h5>
                </div>
                <div class="card-body">
                    <div class="preview-content" style="font-size: 14px;">
                        
                        <div class="mb-4">
                            <h6 class="text-primary mb-2">
                                <i class="fas fa-map-marker-alt me-1"></i> Lokasi
                            </h6>
                            <p class="mb-1"><strong>Alamat:</strong></p>
                            <p class="mb-2 text-muted" id="previewAddress">{{ $address }}</p>
                        </div>

                        <div class="mb-4">
                            <h6 class="text-primary mb-2">
                                <i class="fas fa-map me-1"></i> Peta Lokasi
                            </h6>
                            <div class="maps-preview-wrapper">
                                <div class="maps-responsive-container" id="previewMap">
                                    {!! $maps_embed !!}
                                </div>
                            </div>
                        </div>

                        <div>
                            <h6 class="text-primary mb-2">
                                <i class="fas fa-clock me-1"></i> Jam Operasional
                            </h6>
                            <div class="mb-3 text-muted" id="previewOpDesc">{{ $op_desc }}</div>
                            
                            <h6 class="text-primary mb-2">Catatan:</h6>
                            <div class="text-muted" id="previewOpNotes">{{ $op_notes }}</div>
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

<script>
function formatText(text) {
    if (!text) return '';
    return text
        .replace(/\n/g, '<br>')
        .replace(/\*(.*?)\*/g, '<strong>$1</strong>')
        .replace(/_(.*?)_/g, '<em>$1</em>')
        .replace(/^- (.*?)(?=<br>|$)/gm, '• $1');
}

function fixGoogleMaps() {
    const previewMap = document.getElementById('previewMap');
    if (!previewMap) return;

    const iframes = previewMap.getElementsByTagName('iframe');
    for (let iframe of iframes) {
        iframe.style.width = '100%';
        iframe.style.height = '100%';
        iframe.style.border = '0';
        iframe.removeAttribute('width');
        iframe.removeAttribute('height');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('previewOpDesc').innerHTML = formatText(`{{ $op_desc }}`);
    document.getElementById('previewOpNotes').innerHTML = formatText(`{{ $op_notes }}`);
    setTimeout(fixGoogleMaps, 100);

    document.querySelectorAll('input[name], textarea[name]').forEach(input => {
        input.addEventListener('input', e => {
            switch(e.target.name) {
                case 'company_address':
                    document.getElementById('previewAddress').textContent = e.target.value;
                    break;
                case 'google_maps_embed':
                    document.getElementById('previewMap').innerHTML = e.target.value;
                    setTimeout(fixGoogleMaps, 60);
                    break;
                case 'operational_description':
                    document.getElementById('previewOpDesc').innerHTML = formatText(e.target.value);
                    break;
                case 'operational_notes':
                    document.getElementById('previewOpNotes').innerHTML = formatText(e.target.value);
                    break;
            }
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
    background: #fdfdfd;
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
    background: #4CAF50;
    padding: 10px 26px;
    border-radius: 8px;
    transition: .25s;
    border: none;
}

.btn-success:hover {
    background: #45a049;
    transform: translateY(-1px);
}

.preview-content {
    line-height: 1.7;
}

pre {
    background: #f8f9fa;
    padding: 10px;
    border-radius: 6px;
    border-left: 3px solid #4CAF50;
}

.maps-preview-wrapper {
    border-radius: 10px;
    overflow: hidden;
    background: #f8f9fa;
    border: 1px solid #e2e2e2;
}

.maps-responsive-container {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
}

.maps-responsive-container iframe {
    position: absolute;
    width: 100%;
    height: 100%;
}
</style>

@endsection
