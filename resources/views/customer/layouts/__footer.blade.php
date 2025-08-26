<style>
/* Modern Footer Styling */
.modern-footer {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 50%, #2c3e50 100%);
    position: relative;
    overflow: hidden;
}

.modern-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="1" fill="white" opacity="0.05"/><circle cx="80" cy="80" r="1" fill="white" opacity="0.05"/><circle cx="40" cy="60" r="0.5" fill="white" opacity="0.05"/></svg>');
}

.footer-brand {
    background: linear-gradient(45deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 800;
    font-size: 2.5rem;
    text-decoration: none;
    display: inline-block;
}

.footer-tagline {
    color: #bdc3c7;
    font-size: 1.1rem;
    margin-top: 10px;
}

.social-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin: 0 8px;
    transition: all 0.3s ease;
    text-decoration: none;
    position: relative;
    overflow: hidden;
}

.social-btn.instagram {
    background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
}

.social-btn.tiktok {
    background: linear-gradient(45deg, #ff0050, #00f2ea);
}

.social-btn.youtube {
    background: linear-gradient(45deg, #ff0000, #cc0000);
}

.social-btn.linkedin {
    background: linear-gradient(45deg, #0077b5, #005885);
}

.social-btn:hover {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

.social-btn i {
    color: white;
    font-size: 1.2rem;
    z-index: 2;
}

.footer-section {
    position: relative;
    z-index: 1;
}

.footer-title {
    color: #ecf0f1;
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 20px;
    position: relative;
}

.footer-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 50px;
    height: 3px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    border-radius: 2px;
}

.footer-text {
    color: #bdc3c7;
    line-height: 1.8;
    font-size: 0.95rem;
}

.contact-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    color: #bdc3c7;
    transition: all 0.3s ease;
}

.contact-item:hover {
    color: #ecf0f1;
    transform: translateX(5px);
}

.contact-item i {
    width: 25px;
    height: 25px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    font-size: 0.8rem;
    color: white;
}

.payment-method {
    display: inline-block;
    background: rgba(255,255,255,0.1);
    color: #ecf0f1;
    padding: 8px 15px;
    border-radius: 20px;
    margin: 5px 5px 5px 0;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid rgba(255,255,255,0.2);
}

.payment-method:hover {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    transform: translateY(-2px);
}

.copyright-section {
    background: rgba(0,0,0,0.3);
    backdrop-filter: blur(10px);
    border-top: 1px solid rgba(255,255,255,0.1);
}

.back-to-top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 60px;
    height: 60px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    transition: all 0.3s ease;
    opacity: 0;
    visibility: hidden;
    z-index: 1000;
}

.back-to-top.show {
    opacity: 1;
    visibility: visible;
}

.back-to-top:hover {
    transform: translateY(-5px) scale(1.1);
    color: white;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.footer-section {
    animation: fadeInUp 0.6s ease forwards;
}

.footer-section:nth-child(2) {
    animation-delay: 0.2s;
}

.footer-section:nth-child(3) {
    animation-delay: 0.4s;
}
</style>

<footer class="modern-footer pt-5 mt-5">
    <div class="container py-5">
        <!-- Header Section -->
        <div class="pb-4 mb-5" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="footer-section">
                        <h1 class="footer-brand">🍽️ RestoranKu</h1>
                        <p class="footer-tagline">Cita Rasa Autentik, Pelayanan Terdepan</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="d-flex justify-content-lg-end justify-content-center pt-3">
                        <a href="https://www.instagram.com/restoranku/" class="social-btn instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://tiktok.com/@restoranku" class="social-btn tiktok">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="https://www.youtube.com/@restoranku" class="social-btn youtube">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="https://linkedin.com/company/restoranku" class="social-btn linkedin">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Content Section -->
        <div class="row g-5">
            <div class="col-lg-4 col-md-6">
                <div class="footer-section">
                    <h4 class="footer-title">🎆 Mengapa Memilih Kami?</h4>
                    <p class="footer-text">
                        Kami menghadirkan pengalaman kuliner terbaik dengan bahan-bahan segar, 
                        chef berpengalaman, dan teknologi modern untuk kemudahan pemesanan Anda.
                    </p>
                    <div class="mt-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa fa-star text-warning me-2"></i>
                            <span class="footer-text">Rating 4.8/5 dari 1000+ customer</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fa fa-clock text-info me-2"></i>
                            <span class="footer-text">Buka setiap hari 08:00 - 22:00</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="footer-section">
                    <h4 class="footer-title">📞 Hubungi Kami</h4>
                    <div class="contact-item">
                        <i class="fa fa-map-marker-alt"></i>
                        <span>Jl. Kuliner Raya No.123, Jakarta Selatan</span>
                    </div>
                    <div class="contact-item">
                        <i class="fa fa-phone"></i>
                        <span>+62 21 1234 5678</span>
                    </div>
                    <div class="contact-item">
                        <i class="fa fa-envelope"></i>
                        <span>hello@restoranku.com</span>
                    </div>
                    <div class="contact-item">
                        <i class="fab fa-whatsapp"></i>
                        <span>+62 812 3456 7890</span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="footer-section">
                    <h4 class="footer-title">💳 Metode Pembayaran</h4>
                    <div class="mb-3">
                        <a href="#" class="payment-method">📱 QRIS</a>
                        <a href="#" class="payment-method">💵 Tunai</a>
                        <a href="#" class="payment-method">💳 Kartu Debit</a>
                        <a href="#" class="payment-method">💳 Kartu Kredit</a>
                    </div>
                    
                    <h5 class="footer-title mt-4" style="font-size: 1.1rem;">🚚 Layanan Delivery</h5>
                    <div>
                        <a href="#" class="payment-method">GoFood</a>
                        <a href="#" class="payment-method">GrabFood</a>
                        <a href="#" class="payment-method">Delivery Sendiri</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Copyright Section -->
<div class="copyright-section py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <span class="text-light">
                    <i class="fas fa-copyright me-2"></i>
                    <strong>RestoranKu</strong> <span id="currentYear"></span>. 
                    Semua hak dilindungi.
                </span>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <span class="text-light opacity-75">
                    Dibuat dengan ❤️ untuk pengalaman kuliner terbaik
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Back to Top Button -->
<a href="#" class="back-to-top" id="backToTop">
    <i class="fa fa-arrow-up"></i>
</a>

<script>
// Back to top functionality
window.addEventListener('scroll', function() {
    const backToTop = document.getElementById('backToTop');
    if (window.scrollY > 300) {
        backToTop.classList.add('show');
    } else {
        backToTop.classList.remove('show');
    }
});

document.getElementById('backToTop').addEventListener('click', function(e) {
    e.preventDefault();
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});
</script>