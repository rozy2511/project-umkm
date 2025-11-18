<!doctype html>
<html>
<body>
  <p>Halo,</p>
  <p>Permintaan reset password admin diterima. Kode OTP Anda:</p>

  <h2 style="letter-spacing:4px;">{{ $otp }}</h2>

  <p>Kode berlaku sampai: {{ \Carbon\Carbon::parse($expiresAt)->toDayDateTimeString() }}</p>

  <p>Jika Anda tidak meminta reset, abaikan pesan ini.</p>
</body>
</html>
