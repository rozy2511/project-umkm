<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Ubah Password Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
  <div class="card p-4" style="width:420px;">
    <h5 class="mb-3">Ubah Password Admin</h5>

    @if ($errors->any())
      <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    @if (session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form action="{{ route('admin.reset.change.post') }}" method="POST">
      @csrf

      <div class="mb-3">
        <label class="form-label small">Email</label>
        <input type="email" class="form-control" value="{{ $email }}" readonly>
      </div>

      <div class="mb-3">
        <label class="form-label small">Password Baru</label>
        <input type="password" name="password" class="form-control" required minlength="8">
      </div>

      <div class="mb-3">
        <label class="form-label small">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control" required minlength="8">
      </div>

      <button class="btn btn-primary w-100" type="submit">Ubah Password</button>
      <a href="{{ route('admin.login') }}" class="btn btn-link d-block text-center mt-2">Kembali ke Login</a>
    </form>
  </div>
</div>
</body>
</html>
