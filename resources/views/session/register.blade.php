@extends('master')
@section('content')
<div class="container-fluid" style="background-color: #121212; height: 100vh;">
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="row mb-4 border rounded-4 p-5 bg-dark shadow-lg box-area" style="max-width: 900px;">
            <!-- Miku GIF on the left side -->
            <div class="col-md-5 d-flex justify-content-center align-items-center mb-4 mb-md-0">
                <img src="{{ asset('img/mikulogin.gif') }}" alt="Register GIF" class="img-fluid rounded-4" style="max-width: 100%; height: auto;">
            </div>
            <!-- Registration form on the right side -->
            <div class="col-md-7">
                <div class="text-center mb-4">
                    <h1 class="display-4 fw-bold gradient-text animated-title">Create Your Account</h1>
                    <p class="text-muted">Fill in the details below to register.</p>
                </div>
                <form action="/register" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-outline mb-4">
                        <label class="form-label text-light" for="username">Username</label>
                        <input type="text" class="form-control bg-secondary text-light border-0 animated-input" id="username" placeholder="Enter your username" name="username" required />
                        @error('username')
                        <div class="alert alert-danger fs-6 animated-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label text-light" for="email">Email</label>
                        <input type="email" class="form-control bg-secondary text-light border-0 animated-input" id="email" placeholder="Enter your email" name="email" required />
                        @error('email')
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
                        Register
                    </button>
                </form>
                <div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 me-2 text-light">Already have an account?</p>
                    <a href="/login" class="btn btn-outline-light">Log In</a>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
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
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    .form-control {
        border-radius: 10px;
        transition: border-color 0.3s;
    }
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    @media (max-width: 768px) {
        .box-area {
            padding: 3rem;
        }
    }
</style>
@endsection