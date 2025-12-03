@extends('admin.layouts.main')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="fas fa-share-alt text-primary mr-2"></i>
                Manage Sosial Media
            </h1>
            <p class="text-muted mb-0">Kelola tautan sosial media untuk ditampilkan di website</p>
        </div>
    </div>

    {{-- ALERT LAMA DIHAPUS, DIGANTI SWEETALERT2 --}}

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 text-dark">
                        <i class="fas fa-cog mr-2 text-primary"></i>
                        Konfigurasi Sosial Media
                    </h5>
                    <p class="text-muted mb-0 small">Masukkan username atau tautan sosial media di bawah</p>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.social.bulk-update') }}" id="socialForm">
                        @csrf
                        
                        <div class="social-items">
                            @foreach($socialMedias as $social)
                            <div class="social-item mb-4 pb-4 border-bottom 
                                {{ !$loop->last ? 'border-bottom' : '' }} 
                                {{ $loop->last ? 'mb-0 pb-0 border-0' : '' }}">
                                
                                <div class="row align-items-center">
                                    <div class="col-md-3 mb-3 mb-md-0">
                                        <div class="d-flex align-items-center">
                                            <div class="social-icon-wrapper mr-3">
                                                <div class="social-icon {{ strtolower($social->name) }}">
                                                    <i class="fab fa-{{ $social->icon }}"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 font-weight-bold">{{ $social->name }}</h6>
                                                @if(in_array($social->name, ['Instagram', 'TikTok', 'Twitter']))
                                                    <small class="text-muted">(tanpa @)</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        @if($social->name === 'Instagram')
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light border-right-0">instagram.com/</span>
                                                </div>
                                                <input type="text" 
                                                       name="social[{{ $social->id }}][username]" 
                                                       class="form-control border-left-0" 
                                                       value="{{ old('social.' . $social->id . '.username', str_replace(['https://instagram.com/', 'https://www.instagram.com/'], '', $social->url ?? '')) }}"
                                                       placeholder="username">
                                            </div>
                                        @elseif($social->name === 'Facebook')
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light border-right-0">facebook.com/</span>
                                                </div>
                                                <input type="text" 
                                                       name="social[{{ $social->id }}][username]" 
                                                       class="form-control border-left-0" 
                                                       value="{{ old('social.' . $social->id . '.username', str_replace(['https://facebook.com/', 'https://www.facebook.com/'], '', $social->url ?? '')) }}"
                                                       placeholder="username">
                                            </div>
                                        @elseif($social->name === 'TikTok')
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light border-right-0">tiktok.com/@</span>
                                                </div>
                                                <input type="text" 
                                                       name="social[{{ $social->id }}][username]" 
                                                       class="form-control border-left-0" 
                                                       value="{{ old('social.' . $social->id . '.username', str_replace(['https://tiktok.com/@', 'https://www.tiktok.com/@'], '', $social->url ?? '')) }}"
                                                       placeholder="username">
                                            </div>
                                        @elseif($social->name === 'Twitter')
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light border-right-0">twitter.com/</span>
                                                </div>
                                                <input type="text" 
                                                       name="social[{{ $social->id }}][username]" 
                                                       class="form-control border-left-0" 
                                                       value="{{ old('social.' . $social->id . '.username', str_replace(['https://twitter.com/', 'https://www.twitter.com/'], '', $social->url ?? '')) }}"
                                                       placeholder="username">
                                            </div>
                                        @else
                                            <input type="url" 
                                                   name="social[{{ $social->id }}][url]" 
                                                   class="form-control form-control-sm" 
                                                   value="{{ old('social.' . $social->id . '.url', $social->url ?? '') }}"
                                                   placeholder="https://{{ strtolower($social->name) }}.com/...">
                                        @endif
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" 
                                                       class="custom-control-input" 
                                                       id="active_{{ $social->id }}" 
                                                       name="social[{{ $social->id }}][is_active]" 
                                                       value="1"
                                                       {{ $social->is_active ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="active_{{ $social->id }}">
                                                    <span class="status-label {{ $social->is_active ? 'text-success' : 'text-muted' }}">
                                                        {{ $social->is_active ? 'Aktif' : 'Nonaktif' }}
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-5 pt-3 border-top">
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <button type="submit" class="btn btn-primary px-4 py-2">
                                        <i class="fas fa-save mr-2"></i>
                                        Simpan Perubahan
                                    </button>
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary ml-2">
                                        Batal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-dark">
                        <i class="fas fa-info-circle mr-2 text-info"></i>
                        Panduan Pengisian
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex">
                            <i class="fas fa-check text-success mt-1 mr-2"></i>
                            <div>
                                <strong>Isi hanya username</strong>
                                <p class="text-muted small mb-0">Untuk Instagram, TikTok, Twitter cukup isi username tanpa @</p>
                            </div>
                        </li>
                        <li class="mb-3 d-flex">
                            <i class="fas fa-check text-success mt-1 mr-2"></i>
                            <div>
                                <strong>Toggle Aktif/Nonaktif</strong>
                                <p class="text-muted small mb-0">Hanya sosial media yang diaktifkan yang akan ditampilkan</p>
                            </div>
                        </li>
                        <li class="d-flex">
                            <i class="fas fa-check text-success mt-1 mr-2"></i>
                            <div>
                                <strong>Tautan Lengkap</strong>
                                <p class="text-muted small mb-0">Sistem akan otomatis membuat tautan lengkap</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-dark">
                        <i class="fas fa-eye mr-2 text-primary"></i>
                        Pratinjau
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Berikut contoh tampilan di website:</p>
                    <div class="preview-box bg-light rounded p-3 text-center">
                        <div class="d-flex justify-content-center flex-wrap">
                            @foreach($socialMedias->where('is_active', true)->take(3) as $social)
                                @if($social->url)
                                <a href="#" class="social-preview mx-2 my-1">
                                    <div class="social-icon-preview {{ strtolower($social->name) }}">
                                        <i class="fab fa-{{ $social->icon }}"></i>
                                    </div>
                                </a>
                                @endif
                            @endforeach
                            @for($i = 0; $i < 3 - $socialMedias->where('is_active', true)->whereNotNull('url')->count(); $i++)
                                <div class="social-preview mx-2 my-1">
                                    <div class="social-icon-preview disabled">
                                        <i class="fas fa-plus"></i>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <p class="text-muted small mt-3 mb-0">Icon akan muncul sesuai yang diaktifkan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
/* seluruh style kamu tetap sama tidak diubah */
</style>
@endsection

@section('scripts')

{{-- SWEETALERT CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Update status label when toggle switch changes
document.addEventListener('DOMContentLoaded', function() {
    const switches = document.querySelectorAll('.custom-control-input');
    
    switches.forEach(function(switchEl) {
        switchEl.addEventListener('change', function() {
            const label = this.nextElementSibling.querySelector('.status-label');
            if (this.checked) {
                label.textContent = 'Aktif';
                label.classList.remove('text-muted');
                label.classList.add('text-success');
            } else {
                label.textContent = 'Nonaktif';
                label.classList.remove('text-success');
                label.classList.add('text-muted');
            }
        });
    });
});
</script>

{{-- SWEETALERT SESSION NOTIF --}}
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session("success") }}',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
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
        timer: 3500,
        timerProgressBar: true
    });
</script>
@endif

@endsection
