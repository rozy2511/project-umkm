<footer class="footer">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <div class="container">
        <!-- Social Media Icons -->
        @if(isset($socialMedias) && count($socialMedias) > 0)
        <div class="social-media-section text-center mb-3">
            <div class="social-icons">
                @foreach($socialMedias as $social)
                    @if($social->url)
                    <a href="{{ $social->url }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="social-icon mx-2 {{ strtolower($social->name) }}-icon"
                       aria-label="{{ $social->name }}"
                       title="{{ $social->name }}">
                        <i class="fab fa-{{ $social->icon }}"></i>
                    </a>
                    @endif
                @endforeach
            </div>
        </div>
        @endif
        
        <!-- Copyright -->
        <p class="text-center mb-0">© {{ date('Y') }} UMKM. All Rights Reserved.</p>
    </div>
</footer>

<style>
/* ============================================
   FOOTER STYLES - COMPLETE VERSION
   ============================================ */

/* FOOTER BASE - Soft Gray Gradient */
.footer {
    background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
    padding: 25px 0 20px 0;
    border-top: 1px solid #eaeaea;
    position: relative;
    overflow: hidden;
}

/* Optional: Add very subtle pattern overlay */
.footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(0,0,0,0.03), transparent);
}

/* SOCIAL MEDIA SECTION */
.social-media-section {
    padding: 15px 0;
    margin-bottom: 15px;
    position: relative;
    z-index: 2;
}

.social-icons {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 18px;
    flex-wrap: wrap;
}

/* SOCIAL ICON STYLES */
.social-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    font-size: 20px;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    box-shadow: 
        0 3px 6px rgba(0, 0, 0, 0.08),
        inset 0 1px 0 rgba(255, 255, 255, 0.3);
    border: none;
    outline: none;
    cursor: pointer;
}

/* Add shine effect on icons */
.social-icon::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(
        to bottom right,
        rgba(255, 255, 255, 0.1) 0%,
        rgba(255, 255, 255, 0) 80%
    );
    transform: rotate(30deg);
    pointer-events: none;
}

/* Hover effect */
.social-icon:hover {
    transform: translateY(-3px) scale(1.08);
    box-shadow: 
        0 6px 12px rgba(0, 0, 0, 0.12),
        inset 0 1px 0 rgba(255, 255, 255, 0.4);
}

/* Active/Click effect */
.social-icon:active {
    transform: translateY(-1px) scale(1.05);
    transition: transform 0.1s;
}

/* Platform-specific colors with gradient */
.facebook-icon {
    background: linear-gradient(135deg, #1877F2 0%, #0D8AF0 100%);
    color: white;
}

.instagram-icon {
    background: linear-gradient(45deg, #405DE6, #5851DB, #833AB4, #C13584, #E1306C, #FD1D1D);
    color: white;
}

.twitter-icon {
    background: linear-gradient(135deg, #1DA1F2 0%, #0D8AF0 100%);
    color: white;
}

.tiktok-icon {
    background: linear-gradient(135deg, #000000 0%, #25F4EE 50%, #FE2C55 100%);
    color: white;
}

.youtube-icon {
    background: linear-gradient(135deg, #FF0000 0%, #FF3333 100%);
    color: white;
}

.linkedin-icon {
    background: linear-gradient(135deg, #0A66C2 0%, #0D8AF0 100%);
    color: white;
}

/* Hover effects - slightly darker & more saturated */
.facebook-icon:hover { 
    background: linear-gradient(135deg, #1266d6 0%, #0b70d9 100%); 
}

.instagram-icon:hover { 
    background: linear-gradient(45deg, #3a4fd9, #5143d4, #7a30b3, #b32d77, #cc2a5f, #e61717); 
}

.twitter-icon:hover { 
    background: linear-gradient(135deg, #1a8cd5 0%, #0b70d9 100%); 
}

.tiktok-icon:hover { 
    background: linear-gradient(135deg, #000000 0%, #1cd9d9 50%, #fe1745 100%); 
}

.youtube-icon:hover { 
    background: linear-gradient(135deg, #e00000 0%, #ff0d0d 100%); 
}

.linkedin-icon:hover { 
    background: linear-gradient(135deg, #09519e 0%, #0b70d9 100%); 
}

/* Subtle floating animation */
@keyframes gentle-float {
    0%, 100% { 
        transform: translateY(0); 
    }
    50% { 
        transform: translateY(-5px); 
    }
}

.social-icon:hover i {
    animation: gentle-float 0.5s ease-in-out;
}

/* Copyright text */
.footer p {
    color: #777777;
    font-size: 13px;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #e0e0e0;
    line-height: 1.4;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
    letter-spacing: 0.02em;
}

/* Optional: Add fade-in animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.footer {
    animation: fadeInUp 0.5s ease-out;
}

/* ============================================
   RESPONSIVE BREAKPOINTS
   ============================================ */

/* Tablet (768px and below) */
@media (max-width: 768px) {
    .footer {
        padding: 20px 0 15px 0;
        margin-top: 30px;
    }
    
    .social-icon {
        width: 40px;
        height: 40px;
        font-size: 18px;
    }
    
    .social-icons {
        gap: 16px;
    }
    
    .social-media-section {
        padding: 12px 0;
        margin-bottom: 12px;
    }
    
    .footer p {
        font-size: 12px;
        margin-top: 12px;
        padding-top: 12px;
    }
}

/* Mobile (576px and below) */
@media (max-width: 576px) {
    .footer {
        padding: 18px 0 12px 0;
        margin-top: 25px;
    }
    
    .social-icon {
        width: 36px;
        height: 36px;
        font-size: 17px;
    }
    
    .social-icons {
        gap: 14px;
    }
    
    .social-media-section {
        padding: 10px 0;
        margin-bottom: 10px;
    }
    
    .footer p {
        font-size: 11px;
        margin-top: 10px;
        padding-top: 10px;
    }
}

/* Small Mobile (400px and below) */
@media (max-width: 400px) {
    .footer {
        padding: 15px 0 10px 0;
        margin-top: 20px;
    }
    
    .social-icon {
        width: 34px;
        height: 34px;
        font-size: 16px;
    }
    
    .social-icons {
        gap: 12px;
    }
    
    .social-media-section {
        padding: 8px 0;
        margin-bottom: 8px;
    }
    
    .footer p {
        font-size: 10px;
        margin-top: 8px;
        padding-top: 8px;
    }
}

/* Print styles */
@media print {
    .footer {
        display: none;
    }
}
</style>