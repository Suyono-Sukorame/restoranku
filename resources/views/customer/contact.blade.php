@extends('customer.layouts.master')

<style>
/* Contact Page Modern Styling */
.contact-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 100px 0;
    position: relative;
    overflow: hidden;
}

.contact-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="white" opacity="0.1"/><circle cx="80" cy="80" r="2" fill="white" opacity="0.1"/><circle cx="40" cy="60" r="1" fill="white" opacity="0.1"/></svg>');
}

.contact-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.1);
    padding: 40px;
    transition: all 0.3s ease;
    border: none;
    position: relative;
    overflow: hidden;
}

.contact-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(45deg, #667eea, #764ba2);
}

.contact-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 30px 80px rgba(0,0,0,0.15);
}

.contact-info-item {
    background: rgba(102, 126, 234, 0.05);
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 20px;
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.contact-info-item:hover {
    background: rgba(102, 126, 234, 0.1);
    border-left-color: #667eea;
    transform: translateX(5px);
}

.contact-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.contact-icon i {
    color: white;
    font-size: 1.5rem;
}

.form-floating {
    margin-bottom: 20px;
}

.form-control {
    border: 2px solid #e9ecef;
    border-radius: 15px;
    padding: 15px 20px;
    font-size: 16px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-send {
    background: linear-gradient(45deg, #667eea, #764ba2);
    border: none;
    color: white;
    padding: 15px 30px;
    border-radius: 25px;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.3s ease;
    width: 100%;
}

.btn-send:hover {
    background: linear-gradient(45deg, #5a67d8, #6b46c1);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    color: white;
}

.map-container {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    overflow: hidden;
}

.map-container iframe {
    border-radius: 15px;
    filter: grayscale(20%);
    transition: all 0.3s ease;
}

.map-container:hover iframe {
    filter: grayscale(0%);
}

.section-title {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 15px;
    position: relative;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 60px;
    height: 4px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    border-radius: 2px;
}

.contact-description {
    color: #7f8c8d;
    font-size: 1.1rem;
    line-height: 1.6;
    margin-bottom: 30px;
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

.animate-item {
    animation: fadeInUp 0.6s ease forwards;
}

.animate-item:nth-child(2) {
    animation-delay: 0.2s;
}

.animate-item:nth-child(3) {
    animation-delay: 0.4s;
}

.animate-item:nth-child(4) {
    animation-delay: 0.6s;
}
</style>

<!-- Enhanced Header -->
<div class="contact-header">
    <div class="container text-center position-relative">
        <h1 class="text-white display-4 fw-bold mb-3">📞 Hubungi Kami</h1>
        <p class="text-white-50 fs-5">Kami siap melayani Anda dengan sepenuh hati</p>
    </div>
</div>

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(to bottom, #f8f9fa, #ffffff);">
    <div class="container py-5">
        <div class="row g-5">
            <!-- Contact Info -->
            <div class="col-lg-6">
                <div class="contact-card">
                    <h2 class="section-title">💬 Mari Berkenalan</h2>
                    <p class="contact-description">
                        Kami sangat senang mendengar dari Anda! Tim RestoranKu siap membantu 
                        menjawab pertanyaan dan melayani kebutuhan kuliner Anda.
                    </p>
                    
                    <div class="contact-info-item animate-item">
                        <div class="d-flex align-items-center">
                            <div class="contact-icon">
                                <i class="fa fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h5 class="mb-2 fw-bold">📍 Alamat Kami</h5>
                                <p class="mb-0 text-muted">Jl. Kuliner Raya No. 123<br>Jakarta Selatan, DKI Jakarta 12345</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-info-item animate-item">
                        <div class="d-flex align-items-center">
                            <div class="contact-icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div>
                                <h5 class="mb-2 fw-bold">📞 Telepon</h5>
                                <p class="mb-0 text-muted">+62 21 1234 5678</p>
                                <small class="text-success">Tersedia 24/7 untuk reservasi</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-info-item animate-item">
                        <div class="d-flex align-items-center">
                            <div class="contact-icon">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div>
                                <h5 class="mb-2 fw-bold">✉️ Email</h5>
                                <p class="mb-0 text-muted">hello@restoranku.com</p>
                                <small class="text-info">Respon dalam 24 jam</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-info-item animate-item">
                        <div class="d-flex align-items-center">
                            <div class="contact-icon">
                                <i class="fa fa-clock"></i>
                            </div>
                            <div>
                                <h5 class="mb-2 fw-bold">🕐 Jam Operasional</h5>
                                <p class="mb-1 text-muted">
                                    <strong>Senin - Jumat:</strong> 10:00 - 22:00<br>
                                    <strong>Sabtu - Minggu:</strong> 09:00 - 23:00
                                </p>
                                <small class="text-warning">⭐ Happy Hour: 15:00 - 17:00 (Diskon 20%)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="col-lg-6">
                <div class="contact-card">
                    <h3 class="section-title">💌 Kirim Pesan</h3>
                    <p class="contact-description">Punya pertanyaan, saran, atau ingin memberikan feedback? Kami mendengarkan!</p>
                    
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" placeholder="Nama Anda" value="{{ old('name') }}" required>
                                    <label for="name">👤 Nama Anda</label>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" placeholder="Email Anda" value="{{ old('email') }}" required>
                                    <label for="email">📧 Email Anda</label>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                           id="subject" name="subject" placeholder="Subjek" value="{{ old('subject') }}" required>
                                    <label for="subject">📝 Subjek</label>
                                    @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control @error('message') is-invalid @enderror" 
                                              placeholder="Pesan Anda" id="message" name="message" 
                                              style="height: 120px" required>{{ old('message') }}</textarea>
                                    <label for="message">💬 Pesan Anda</label>
                                    @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn-send" type="submit">
                                    <i class="fa fa-paper-plane me-2"></i>Kirim Pesan Sekarang
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Map Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="map-container">
                    <h3 class="section-title text-center mb-4">🗺️ Temukan Kami</h3>
                    <p class="text-center text-muted mb-4">Lokasi strategis di jantung kota dengan akses mudah dan parkir luas</p>
                    <div class="ratio ratio-21x9">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.8195613!3d-6.2087634!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5390917b759%3A0x6b45e67356080477!2sMonas%2C%20Gambir%2C%20Kecamatan%20Gambir%2C%20Kota%20Jakarta%20Pusat%2C%20Daerah%20Khusus%20Ibukota%20Jakarta!5e0!3m2!1sen!2sid!4v1635724073795!5m2!1sen!2sid" 
                                style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Animate elements on scroll
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.contact-card, .contact-info-item').forEach(item => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(30px)';
        item.style.transition = 'all 0.6s ease';
        observer.observe(item);
    });
});
</script>
@endsection