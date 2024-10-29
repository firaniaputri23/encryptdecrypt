@extends('master') 
@include('navbar')
@php
    $homeController = app('App\Http\Controllers\HomeController');
@endphp
@section('content')
<div class="container-fluid" style="background-color: #121212; height: 100vh;">
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-4 p-5 bg-dark shadow-lg box-area" style="max-width: 1200px;">
            
            <div class="col-md-6"> <!-- Left grid for form -->
                <div class="col-12 text-center mb-4">
                    <h1 class="display-4 fw-bold gradient-text animated-title">Edit Your Profile</h1>
                    <p style="color: lightgrey;">Update your profile information below.</p> <!-- Light grey color -->
                </div>
                <form action="/home" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="form-group">
                                <label class="fw-bold text-light" style="font-size: 20px;">Full Name</label>
                                <input type="text" class="form-control bg-secondary text-light border-0 animated-input" name="fullname" placeholder="Enter your Full Name" value="{{ $homeController->AESdecrypt($aess->first()->fullname, $aess->first()->fullname_key, $aess->first()->fullname_iv, 0) }}" required>
                                @error('fullname')
                                <div class="alert alert-danger fs-6 animated-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label class="fw-bold text-light" style="font-size: 20px;">ID Card</label>
                                <input type="file" class="form-control bg-secondary text-light border-0 animated-input" name="id_card">
                                @error('id_card')
                                <div class="alert alert-danger fs-6 animated-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label class="fw-bold text-light" style="font-size: 20px;">Video</label>
                                <input type="file" class="form-control bg-secondary text-light border-0 animated-input" name="video">
                                @error('video')
                                <div class="alert alert-danger fs-6 animated-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label class="fw-bold text-light" style="font-size: 20px;">Document</label>
                                <input type="file" class="form-control bg-secondary text-light border-0 animated-input" name="document">
                                @error('document')
                                <div class="alert alert-danger fs-6 animated-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-dark w-100 animated-button mt-4" type="submit">Replace</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6 d-flex justify-content-center align-items-center"> <!-- Right grid for GIF -->
                <img src="{{ url('img/mikulogin.gif') }}" alt="Profile Reminder GIF" class="img-fluid" style="max-width: 80%; height: auto;" />
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
            padding: 2rem;
        }
        .form-group {
            margin-bottom: 1rem; /* Adjust margin for smaller screens */
        }
    }
</style>
@endsection