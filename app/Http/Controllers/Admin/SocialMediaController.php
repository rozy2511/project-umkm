<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SocialMediaController extends Controller
{
    // Tampilkan halaman social media settings
    public function index()
    {
        $socialMedias = SocialMedia::orderBy('order')->get();
        return view('website.admin.sosmed.sosmed', compact('socialMedias'));
    }

    // Update single social media (PUT /admin/social-media/{id})
    public function update(Request $request, $id)
    {
        $request->validate([
            'url' => 'nullable|url',
        ]);

        $socialMedia = SocialMedia::findOrFail($id);
        
        $socialMedia->update([
            'url' => $request->url,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->back()->with('success', 'Social media updated successfully!');
    }

    // BULK UPDATE - untuk form submission (POST /admin/social-media)
    public function bulkUpdate(Request $request)
    {
        try {
            $socialData = $request->input('social', []);
            
            DB::beginTransaction();
            
            foreach ($socialData as $id => $data) {
                $socialMedia = SocialMedia::find($id);
                
                if ($socialMedia) {
                    // Format URL berdasarkan platform
                    $url = $this->formatSocialUrl(
                        $socialMedia->name, 
                        $data['username'] ?? $data['url'] ?? ''
                    );
                    
                    $socialMedia->update([
                        'url' => $url ?: null,
                        'is_active' => isset($data['is_active']) && $data['is_active'] == '1'
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Pengaturan sosial media berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error updating social media: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    // Helper function untuk format URL
    private function formatSocialUrl($platform, $value)
    {
        if (empty(trim($value))) {
            return null;
        }

        $value = trim($value);
        
        // Jika sudah berupa URL lengkap, langsung return
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        // Hapus karakter @ di awal jika ada
        $username = ltrim($value, '@');
        
        switch ($platform) {
            case 'Instagram':
                return 'https://instagram.com/' . $username;
            case 'Facebook':
                return 'https://facebook.com/' . $username;
            case 'TikTok':
                return 'https://tiktok.com/@' . $username;
            case 'Twitter':
                return 'https://twitter.com/' . $username;
            case 'YouTube':
                // Handle YouTube khusus
                if (str_starts_with($username, 'channel/') || 
                    str_starts_with($username, 'c/') || 
                    str_starts_with($username, 'user/')) {
                    return 'https://youtube.com/' . $username;
                }
                return 'https://youtube.com/@' . $username;
            case 'LinkedIn':
                return 'https://linkedin.com/in/' . $username;
            default:
                return 'https://' . $username;
        }
    }
}