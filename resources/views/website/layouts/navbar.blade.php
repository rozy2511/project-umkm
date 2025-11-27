<nav class="navbar transparent" id="navbar">
    <div class="container">
        <div class="logo">
            <a href="/">Jajan Pasar TradisionalP</a>
        </div>

        <ul class="nav-links">
            <li><a href="/">Beranda</a></li>
            <li><a href="/produk">Produk</a></li>
            <li><a href="/tentang">Tentang</a></li>
            <li><a href="/kontak">Kontak</a></li>
        </ul>

        <div class="menu-toggle">
            ☰
        </div>
    </div>
</nav>

<script>

document.addEventListener('click', function(e) {
    if (e.target.closest('.menu-toggle')) {
        document.querySelector('.nav-links').classList.toggle('active');
        console.log('Menu di-toggle!');
    }
});
</script>
