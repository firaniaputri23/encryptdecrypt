@extends('master') 
@include('navbar')
@section('content')
<div class="container-fluid" style="background-color: #121212; height: 100vh;">
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-4 shadow-lg box-area" style="max-width: 1000px; width: 100%; height: 700px;"> <!-- Increased height -->
            <div class="col-md-6 d-flex justify-content-center align-items-center" style="background-color: #1c1c1c;">
                <img src="{{ asset('img/mikulogin.gif') }}" alt="Profile GIF" class="img-fluid" style="max-width: 100%; height: auto; object-fit: cover;">
            </div>
            <div class="col-md-6 d-flex flex-column justify-content-center p-5">
                <div class="text-center mb-4">
                    <h1 class="display-4 fw-bold gradient-text animated-title">Complete Your Profile</h1>
                    <p style="color: white;">Fill in the details below to complete your profile.</p>
                </div>
                <form action="/home" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-4">
                        <label class="fw-bold text-light" style="font-size: 20px;">Full Name</label>
                        <input type="text" class="form-control bg-secondary text-light border-0 animated-input" name="fullname" placeholder="Enter your Full Name" value="{{ old('fullname') }}" required>
                        @error('fullname')
                        <div class="alert alert-danger fs-6 animated-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label class="fw-bold text-light" style="font-size: 20px;">ID Card</label>
                        <input type="file" class="form-control bg-secondary text-light border-0 animated-input" name="id_card" value="{{ old('id_card') }}" required>
                        @error('id_card')
                        <div class="alert alert-danger fs-6 animated-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label class="fw-bold text-light" style="font-size: 20px;">Document</label>
                        <input type="file" class="form-control bg-secondary text-light border-0 animated-input" name="document" value="{{ old('document') }}" required>
                        @error('document')
                        <div class="alert alert-danger fs-6 animated-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label class="fw-bold text-light" style="font-size: 20px;">Video</label>
                        <input type="file" class="form-control bg-secondary text-light border-0 animated-input" name="video" value="{{ old('video') }}" required>
                        @error('video')
                        <div class="alert alert-danger fs-6 animated-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="btn btn-dark w-100 animated-button mt-4" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .box-area {
        border-radius: 20px;
        animation: fadeIn 0.5s ease-in-out;
        overflow: hidden; /* Ensure content fits within rounded corners */
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
            height: auto; /* Allow height to adjust on smaller screens */
            flex-direction: column; /* Stack columns */
        }
        .col-md-6 {
            width: 100%; /* Full width on smaller screens */
        }
    }
</style>
@endsection