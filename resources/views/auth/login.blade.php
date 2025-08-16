<x-guest-layout>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <!-- Box login -->
        <div class="p-5 shadow-lg rounded-4 bg-white" style="max-width: 400px; width: 90%;">
            <div class="text-center mb-4">
                <img src="{{ asset('assets/admin/images/logo.png') }}" alt="Logo" class="img-fluid" style="max-height: 80px;">
            </div>
            <h1 class="text-center mb-2">Log in Restoranku</h1>
            <p class="text-center text-muted mb-4">Silahkan masuk untuk mengelola layanan restoranku</p>

            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group position-relative has-icon-left mb-3">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="form-control form-control-xl @error('email') is-invalid @enderror" placeholder="Email">
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    @error('email')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group position-relative has-icon-left mb-3">
                    <input id="password" type="password" name="password" required
                           class="form-control form-control-xl @error('password') is-invalid @enderror" placeholder="Password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    @error('password')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-check form-check-lg d-flex align-items-center mb-3">
                    <input class="form-check-input me-2" type="checkbox" name="remember" id="remember_me">
                    <label class="form-check-label text-gray-600" for="remember_me">
                        Keep me logged in
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mb-3 w-100">Log in</button>

                @if (Route::has('password.request'))
                    <div class="text-center">
                        <a class="font-bold text-gray-600" href="{{ route('password.request') }}">Forgot password?</a>
                    </div>
                @endif
            </form>

            <div class="text-center mt-4">
                <p class="text-gray-600">Don't have an account? 
                    <a href="{{ route('register') }}" class="font-bold">Sign up</a>.
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>