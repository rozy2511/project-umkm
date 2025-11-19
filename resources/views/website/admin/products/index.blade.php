@extends('admin.layouts.main')

@section('content')
<div class="container-fluid px-4">
    <!-- Flash Messages - iPhone Style Popup -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
        @if(session('success'))
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="4000">
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
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="4000">
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
        <h1 class="h3 mb-0 text-gray-800">Data Produk</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Produk
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Produk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $products->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Produk</h6>
            <div class="d-flex gap-2">
                <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Cari produk..." style="width: 200px;">
                <button class="btn btn-sm btn-outline-secondary" onclick="clearSearch()">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="productsTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">#</th>
                            <th>Nama Produk</th>
                            <th width="15%">Harga</th>
                            <th width="20%">Slug</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $p)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="product-icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-dark">{{ $p->name }}</div>
                                        <small class="text-muted">ID: {{ $p->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-success font-weight-bold">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                            <td>
                                <code class="bg-light px-2 py-1 rounded">{{ $p->slug }}</code>
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-2">
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.products.edit', $p->id) }}" 
                                       class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center gap-2">
                                        <i class="fas fa-edit fa-xs"></i>
                                        <span>Edit</span>
                                    </a>

                                    <!-- Preview Button -->
                                    <a href="{{ route('products.show', $p->slug) }}" 
                                       target="_blank"
                                       class="btn btn-sm btn-outline-info d-flex align-items-center justify-content-center gap-2">
                                        <i class="fas fa-eye fa-xs"></i>
                                        <span>Preview</span>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" class="d-inline w-100">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus produk {{ $p->name }}?')">
                                            <i class="fas fa-trash fa-xs"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            @if($products->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-3x text-gray-300 mb-3"></i>
                <h5 class="text-gray-500">Belum ada produk</h5>
                <p class="text-muted">Mulai dengan menambahkan produk pertama Anda</p>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-plus me-2"></i>Tambah Produk Pertama
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.product-icon {
    font-size: 14px;
}
.table th {
    border-top: none;
    font-weight: 600;
    color: #6c757d;
}
.card {
    border: none;
    border-radius: 10px;
}
.btn-sm {
    padding: 0.4rem 0.75rem;
    font-size: 0.8rem;
    border-radius: 6px;
    transition: all 0.2s;
}
.btn-sm:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* iPhone Style Toast Notification */
.toast {
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    backdrop-filter: blur(10px);
    min-width: 320px;
    margin-bottom: 10px;
    border: none;
    overflow: hidden;
}
.toast-header {
    padding: 12px 16px;
    font-weight: 600;
}
.toast-body {
    padding: 12px 16px;
    font-size: 0.9rem;
    color: #333;
}
.toast.show {
    opacity: 1;
    animation: slideInRight 0.3s ease-out;
}
.toast.hide {
    animation: slideOutRight 0.3s ease-in;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOutRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}
</style>

<script>
// Simple search functionality
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#productsTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

function clearSearch() {
    document.getElementById('searchInput').value = '';
    const rows = document.querySelectorAll('#productsTable tbody tr');
    rows.forEach(row => row.style.display = '');
}

// Simple auto-hide untuk toast
document.addEventListener('DOMContentLoaded', function() {
    const toasts = document.querySelectorAll('.toast');
    
    toasts.forEach(toast => {
        // Show toast
        toast.classList.add('show');
        
        // Auto hide setelah 4 detik
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                toast.remove();
            }, 300); // Wait for animation to finish
        }, 4000);
        
        // Manual close dengan button
        const closeBtn = toast.querySelector('.btn-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            });
        }
    });
});
</script>
@endsection