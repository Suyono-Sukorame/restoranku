<style>
/* Enhanced Navbar Styling */
.modern-navbar {
    background: rgba(255, 255, 255, 0.95) !important;
    backdrop-filter: blur(20px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    padding: 10px 0;
}

.modern-navbar.scrolled {
    background: rgba(255, 255, 255, 0.98) !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    padding: 5px 0;
}

.navbar-brand-modern {
    background: linear-gradient(45deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 800;
    font-size: 2rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.navbar-brand-modern:hover {
    transform: scale(1.05);
    -webkit-text-fill-color: transparent;
}

.nav-link-modern {
    color: #2c3e50 !important;
    font-weight: 600;
    padding: 12px 20px !important;
    border-radius: 25px;
    transition: all 0.3s ease;
    position: relative;
    margin: 0 5px;
}

.nav-link-modern:hover,
.nav-link-modern.active {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.cart-icon {
    background: linear-gradient(45deg, #ff6b6b, #ee5a24);
    color: white;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    margin-right: 15px;
}

.cart-icon:hover {
    transform: scale(1.1) rotate(5deg);
    color: white;
    box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
}

.cart-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #e74c3c;
    color: white;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: bold;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.admin-btn {
    background: linear-gradient(45deg, #4834d4, #686de0);
    border: none;
    color: white;
    padding: 12px 25px;
    border-radius: 25px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
}

.admin-btn:hover {
    background: linear-gradient(45deg, #3742fa, #5352ed);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(72, 52, 212, 0.4);
    color: white;
}

.navbar-toggler-modern {
    border: none;
    padding: 8px 12px;
    border-radius: 8px;
    background: linear-gradient(45deg, #667eea, #764ba2);
}

.navbar-toggler-modern:focus {
    box-shadow: none;
}

.navbar-toggler-icon-modern {
    color: white;
    font-size: 1.2rem;
}
</style>

<div class="container-fluid fixed-top">
    <div class="container px-0">
        <nav class="navbar navbar-expand-xl modern-navbar" id="mainNavbar">
            <a href="{{ url('/') }}" class="navbar-brand-modern">
                🍽️ RestoranKu
            </a>
            
            <button class="navbar-toggler navbar-toggler-modern" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <i class="fa fa-bars navbar-toggler-icon-modern"></i>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="{{ url('/') }}" class="nav-link nav-link-modern {{ request()->is('/') ? 'active' : '' }}">
                        🏠 Home
                    </a>
                    <a href="{{ route('menu') }}" class="nav-link nav-link-modern {{ request()->routeIs('menu') ? 'active' : '' }}">
                        🍽️ Menu
                    </a>
                    <a href="{{ route('contact') }}" class="nav-link nav-link-modern {{ request()->routeIs('contact') ? 'active' : '' }}">
                        📞 Kontak
                    </a>
                </div>
                
                <div class="d-flex align-items-center">
                    <a href="{{ route('cart') }}" class="cart-icon">
                        <i class="fa fa-shopping-cart"></i>
                        <span id="cart-badge" class="cart-badge" style="display: none;">0</span>
                    </a>
                    
                    <a href="{{ route('login') }}" class="admin-btn">
                        <i class="fa fa-user me-2"></i>Admin
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>

<script>
// Navbar scroll effect
window.addEventListener('scroll', function() {
    const navbar = document.getElementById('mainNavbar');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});
</script>

        {{-- <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Menu Kami</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item active text-primary">Silakan pilih menu favorit anda</li>
            </ol>
        </div>
        <!-- Single Page Header End --> --}}