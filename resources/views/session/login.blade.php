@extends('master')
@section('content')
<div class="container-fluid" style="background-color: #121212; height: 100vh;">
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="row mb-4 border rounded-4 p-5 bg-dark shadow-lg box-area" style="width: 80%; max-width: 900px; opacity: 0; transform: translateY(20px); animation: fadeInUp 0.8s forwards;">
            <!-- Left column for the GIF -->
            <div class="col-md-6 text-center d-flex align-items-center justify-content-center" style="animation: fadeIn 0.5s forwards; animation-delay: 0.2s;">
                <img src="{{ asset('img/mikulogin.gif') }}" alt="Welcome GIF" class="img-fluid" style="max-width: 100%; animation: fadeIn 0.8s forwards; animation-delay: 0.3s;">
            </div>
            <!-- Right column for the form -->
            <div class="col-md-6">
                <div class="text-center mb-4">
                    <h1 class="display-4 fw-bold gradient-text animated-title">Welcome Back!</h1>
                    <h1 class="display-4 fw-bold gradient-text animated-title">おかえり</h1>
                    <p class="text-light">Please enter your credentials to access your account.</p>
                </div>
                <form action="/login" method="post" style="animation: fadeIn 0.5s forwards; animation-delay: 0.4s;">
                    @csrf
                    <div class="form-outline mb-4">
                        <label class="form-label text-light" for="username">Username</label>
                        <input type="text" class="form-control bg-secondary text-light border-0 animated-input" id="username" placeholder="Enter your username" name="username" required />
                        @error('username')
                        <div class="alert alert-danger fs-6 animated-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label text-light" for="password">Password</label>
                        <input type="password" class="form-control bg-secondary text-light border-0 animated-input" id="password" placeholder="Enter your password" name="password" required />
                        @error('password')
                        <div class="alert alert-danger fs-6 animated-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-dark align-items-center w-100 d-flex flex-column mb-4 animated-button">
                        Login
                    </button>
                </form>
                <div class="d-flex align-items-center justify-content-center pb-4" style="animation: fadeIn 0.5s forwards; animation-delay: 0.6s;">
                    <p class="mb-0 me-2 text-light">Don't have an account?</p>
                    <a href="/register" class="btn btn-outline-light">Create new</a>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    /* Animation Keyframes */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .box-area {
        border-radius: 20px;
        animation: fadeIn 0.5s ease-in-out;
    }
    .gradient-text {
        background: linear-gradient(135deg, #00bcd4, #333333);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: slideIn 0.5s forwards;
    }
    .animated-title {
        opacity: 0;
        transform: translateY(-20px);
        animation: slideIn 0.5s forwards;
    }
    .animated-input {
        opacity: 0;
        transform: translateY(20px);
        animation: slideIn 0.5s forwards;
        animation-delay: 0.1s;
    }
    .animated-error {
        opacity: 0;
        transform: translateY(10px);
        animation: slideIn 0.5s forwards;
        animation-delay: 0.1s;
    }
    .animated-button {
        opacity: 0;
        transform: translateY(20px);
        animation: slideIn 0.5s forwards;
        animation-delay: 0.2s;
    }
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .form-control {
        border-radius: 10px;
        transition: border-color 0.3s;
    }
    .form-control:focus {
        border-color: #00bcd4;
        box-shadow: 0 0 0 0.2rem rgba(0, 188, 212, 0.25);
    }
    .btn-primary {
        background-color: #1d72b8;
        border-radius: 10px;
        transition: background-color 0.3s;
    }
    .btn-primary:hover {
        background-color: #155a8a;
    }
    @media (max-width: 768px) {
        .box-area {
            width: 100%;
            padding: 2rem;
        }
    }
</style>
@endsection