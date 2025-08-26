<!DOCTYPE html>
<html lang="id">
<head>
    @include('customer.layouts.__header') 
    <!-- __header biasanya berisi <meta>, <title>, css links dll -->
</head>
<body>

    <!-- Spinner Start -->
    <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->
    
    <!-- Navbar start -->
    @include('customer.layouts.__navbar')
    <!-- Navbar End -->

    <div class="container-fluid px-0">
        @include('components.alert')
    </div>
    
    @yield('content')

    <!-- Footer Start -->
    @include('customer.layouts.__footer')
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   

    
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/customer/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets/customer/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/customer/lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('assets/customer/lib/owlcarousel/owl.carousel.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('assets/customer/js/main.js') }}"></script>

    <script>
        document.getElementById('currentYear').textContent = new Date().getFullYear();
        
        // PWA Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('SW registered: ', registration);
                    })
                    .catch(function(registrationError) {
                        console.log('SW registration failed: ', registrationError);
                    });
            });
        }
        
        // PWA Install Prompt
        let deferredPrompt;
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            
            // Show install button
            const installBtn = document.createElement('button');
            installBtn.innerHTML = '📱 Install App';
            installBtn.className = 'btn btn-primary btn-sm position-fixed';
            installBtn.style.cssText = 'bottom: 20px; left: 20px; z-index: 1000;';
            installBtn.onclick = () => {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        installBtn.remove();
                    }
                });
            };
            document.body.appendChild(installBtn);
        });
    </script>
    @include('customer.layouts.__cart_script')
    @yield('script')

</body>
</html>
