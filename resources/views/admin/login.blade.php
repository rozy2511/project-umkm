<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #eef1f5;
        }

        .login-card {
            border-radius: 14px;
        }

        /* Normal state */
        .input-group .form-control {
            border-right: none;
            background-color: #f9fafb;
        }

        .input-group-text {
            background-color: #f9fafb;
            border-left: none;
        }

        .eye-icon {
            width: 20px;
            height: 20px;
            color: #6c6f75;
            transition: .2s;
        }

        /* Tombol icon mata tanpa kotak */
        .eye-btn {
            border: none;
            background: transparent;
            padding: 0 6px;
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        .eye-btn:focus {
            outline: none;
            box-shadow: none;
        }

        /* Fokus state */
        .input-group:focus-within .form-control,
        .input-group:focus-within .input-group-text {
            background-color: #ffffff;
            border-color: #86b7fe;
            box-shadow: none;
        }

        /* Error state */
        .is-invalid,
        .input-group.is-invalid .form-control,
        .input-group.is-invalid .input-group-text {
            border-color: #dc3545 !important;
            background-color: #fff5f5 !important;
        }

        .input-group.is-invalid .eye-icon {
            color: #dc3545 !important;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-4">

        <div class="card shadow login-card">
            <div class="card-header text-center py-3">
                <h4 class="m-0">Login Admin</h4>
            </div>

            <div class="card-body">

                @if(session('error'))
                    <div class="alert alert-danger py-2">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Password Admin</label>

                        <div class="input-group @error('password') is-invalid @enderror">

                            <input id="password"
                                   type="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Masukkan password"
                                   required autofocus>

                            <span class="input-group-text" style="border-left:none; background-color:#f9fafb;">
                                <button type="button" id="togglePassword" class="eye-btn" title="Lihat Password">
                                    
                                    <!-- eye icon -->
                                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="eye-icon" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8z"/>
                                        <path d="M8 5a3 3 0 1 1 0 6A3 3 0 0 1 8 5z" fill="#fff"/>
                                    </svg>

                                    <!-- eye slash icon -->
                                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="eye-icon d-none" viewBox="0 0 16 16">
                                        <path d="M13.359 11.238C15.06 9.87 16 8 16 8s-3-5.5-8-5.5A8.7 8.7 0 0 0 3.5 4.467l-.984-.985a.75.75 0 1 0-1.06 1.06l11 11a.75.75 0 0 0 1.06-1.06l-1.157-1.157ZM8 11a3 3 0 0 1-3-3c0-.395.08-.77.225-1.112l1.112 1.112A1.5 1.5 0 0 0 8 9.5a1.49 1.49 0 0 0 .453-.07l1.158 1.158A3 3 0 0 1 8 11Zm0-6a3 3 0 0 1 2.775 1.843l-1.3 1.3A1.5 1.5 0 0 0 8 6.5c-.249 0-.49.06-.7.171L5.867 5.238A3 3 0 0 1 8 5Z"/>
                                        <path d="M3.35 6.588 1.72 4.957A13.18 13.18 0 0 0 0 8s3 5.5 8 5.5c1.263 0 2.41-.244 3.445-.676l-1.534-1.534C9.21 11.7 8.617 11.8 8 11.8 5 11.8 2.72 9.5 2.72 9.5c.28-.41.63-.89 1.11-1.41l-.48-.52Z"/>
                                    </svg>

                                </button>
                            </span>
                        </div>

                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-2">Login</button>

                    <a href="{{ route('admin.reset.request') }}"
   class="btn btn-link w-100 text-center"
   style="text-decoration:none;">
    Reset Password
</a>

                </form>

            </div>
        </div>

    </div>
</div>

<script>
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const eyeOpen = document.getElementById('eyeOpen');
    const eyeClosed = document.getElementById('eyeClosed');

    toggle.addEventListener('click', function () {
        const show = password.type === 'password';
        password.type = show ? 'text' : 'password';

        eyeOpen.classList.toggle('d-none', show);
        eyeClosed.classList.toggle('d-none', !show);
    });
</script>

</body>
</html>
