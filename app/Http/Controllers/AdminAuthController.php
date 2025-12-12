<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminResetOtp;
use Carbon\Carbon;


class AdminAuthController extends Controller
{
    // Tampilkan form meminta OTP (email readonly)
public function showResetRequest()
{
    // fixed admin email (sama seperti di controller)
    $email = $this->adminEmail;
    return view('admin.reset_request', compact('email'));
}

// Kirim OTP ke email (simpan di session)
public function sendResetOtp(Request $request)
{
    $email = $this->adminEmail;
    $key = 'send-otp|' . $request->ip(); // rate limiter key

    // rate limit: 3 kali per 60 detik (1 menit) <-- DIUBAH
    if (RateLimiter::tooManyAttempts($key, 3)) {
        $seconds = RateLimiter::availableIn($key);
        $minutes = ceil($seconds / 60);
        
        return back()->withErrors([
            'error' => "Terlalu banyak permintaan. Coba lagi dalam {$minutes} menit."
        ]);
    }

    RateLimiter::hit($key, 60); // decay 60 detik (1 menit) <-- DIUBAH DARI 900 KE 60

    // generate OTP 6 digit
    $otp = random_int(100000, 999999);

    // simpan di session: code + expires_at (Carbon)
    $expiresAt = Carbon::now()->addMinutes(5);
    session([
        'admin_reset_otp' => [
            'code' => (string)$otp,
            'expires_at' => $expiresAt->toDateTimeString(),
        ]
    ]);

    // Kirim email (Mailable)
    Mail::to($email)->send(new AdminResetOtp($otp, $expiresAt));

    // Redirect ke halaman verifikasi
    return redirect()->route('admin.reset.verify')->with('status','Kode OTP telah dikirim ke email admin.');
}

// Tampilkan form verifikasi OTP
public function showVerifyOtp()
{
    $email = $this->adminEmail;
    return view('admin.verify_otp', compact('email'));
}

// Proses verifikasi OTP
public function verifyOtp(Request $request)
{
    $request->validate([
        'otp' => 'required|digits:6',
    ]);

    $data = session('admin_reset_otp');

    if (! $data) {
        return back()->withErrors(['otp' => 'Tidak ada OTP yang dikirim. Silakan minta ulang.']);
    }

    // cek expired
    $expiresAt = Carbon::parse($data['expires_at']);
    if (Carbon::now()->greaterThan($expiresAt)) {
        session()->forget('admin_reset_otp');
        return back()->withErrors(['otp' => 'OTP sudah kadaluarsa. Silakan minta ulang.']);
    }

    if (! hash_equals($data['code'], $request->otp)) {
        return back()->withErrors(['otp' => 'OTP salah.']);
    }

    // OTP valid -> tandai session verified (temporary flag)
    session(['admin_reset_verified' => true]);

    // optionally remove OTP code to prevent reuse
    // session()->forget('admin_reset_otp');

    return redirect()->route('admin.reset.change');
}

// Tampilkan form change password (hanya jika verified)
public function showChangePassword()
{
    if (! session('admin_reset_verified')) {
        return redirect()->route('admin.reset.request')->withErrors(['error' => 'Akses tidak sah.']);
    }

    $email = $this->adminEmail;
    return view('admin.change_password', compact('email'));
}

// Proses change password
public function changePassword(Request $request)
{
    if (! session('admin_reset_verified')) {
        return redirect()->route('admin.reset.request')->withErrors(['error' => 'Akses tidak sah.']);
    }

    $request->validate([
        'password' => 'required|string|min:8|confirmed',
    ]);

    $email = $this->adminEmail;
    $admin = \App\Models\User::where('email', $email)->first();

    if (! $admin) {
        return redirect()->route('admin.reset.request')->withErrors(['error' => 'Admin tidak ditemukan.']);
    }

    // update password (model akan auto-hash jika cast 'password' => 'hashed')
    $admin->password = $request->password;
    $admin->save();

    // bersihkan session otp & verified
    session()->forget(['admin_reset_otp','admin_reset_verified']);

    return redirect()->route('admin.login')->with('status','Password berhasil diubah. Silakan login.');
}

    // email admin fixed
    protected string $adminEmail = 'muhammadfachrurrozyrozy@gmail.com';


    // tampilkan login (password-only)
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // proses login (password only)
    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $key = $this->throttleKey($request);

        // limit: 5 attempts per minute
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'password' => ["Terlalu banyak percobaan. Coba lagi setelah {$seconds} detik."],
            ])->status(429);
        }

        $credentials = [
            'email' => $this->adminEmail,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // pastikan punya role admin (jika kamu pakai kolom role)
            if (auth()->user()->role !== 'admin') {
                Auth::logout();
                throw ValidationException::withMessages([
                    'password' => ['Unauthorized.'],
                ])->status(403);
            }

            RateLimiter::clear($key);
            $request->session()->regenerate();

            // redirect ke admin dashboard (sesuaikan route)
            return redirect()->intended(route('admin.dashboard'));
        }

        // gagal -> hit limiter
        RateLimiter::hit($key, 60);

        throw ValidationException::withMessages([
            'password' => ['Password salah.'],
        ]);
    }

    // logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('admin.login'));
    }

    protected function throttleKey(Request $request): string
    {
        return Str::lower($this->adminEmail).'|'.$request->ip();
    }
}
