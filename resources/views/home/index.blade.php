@extends('master')
@include('navbar')

@php
    $homeController = app('App\Http\Controllers\HomeController');
@endphp

@section('content')
<div class="container-fluid" style="background-color: #121212; min-height: 100vh;">
    @if(count($aess) > 0)
    <div class="container py-5 vh-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="card mb-3 border-0 shadow-lg bg-dark text-light rounded-4 animated-card" style="border-radius: 0.5rem;">
                <div class="row">
                    <div class="col-md-4" style="background: linear-gradient(135deg, #e0ffff, #d3d3d3); border-top-left-radius: 0.5rem; border-bottom-left-radius: 0.5rem; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                        <img src="{{ url('img/registermiku.gif') }}" alt="Avatar" class="img-fluid rounded-circle mb-4" style="width: 200px; height: 200px; object-fit: cover;"> <!-- Set fixed width and height -->
                        <h2 class="fw-bold username">{{ Auth::user()->username }}</h2> <!-- Username in black -->
                        @if(session('error'))
                        <div class="alert alert-danger mt-3" role="alert">
                            {{ session('error') }}
                        </div>
                        @endif
                        @if(session('success'))
                        <div class="alert alert-success mt-3" role="alert">
                            {{ session('success') }}
                        </div>
                        @endif
                    </div>

                    <div class="col-md-8">
                        <div class="card-body p-4">
                            <!-- AES Section -->
                            <div class="section-header bg-gradient-aes">
                                <h2 class="fw-bold text-uppercase gradient-text">AES</h2>
                                <h3 class="fw-bold text gradient-text">Advanced Encryption Standard</h3>
                            </div>
                            <hr class="mb-4">
                            <div class="row">
                                @foreach ($aess as $aes)
                                <div class="col-12 col-md-6 col-lg-3 mb-3 animated-card-item">
                                    <h6 class="text-light"><strong>Full Name</strong></h6>
                                    <p class="text-light full-name">{{ $homeController->AESdecrypt($aes->fullname, $aes->fullname_key, $aes->fullname_iv, 0) }}</p> <!-- Full name in white -->
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-3 animated-card-item">
                                    <h6>ID Card</h6>
                                    <a href="/download/aes/id_card/{{ $aes->user_id }}/{{ str_replace('/', '', $aes->id_card_key) }}" class="btn btn-primary btn-sm">Download</a>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-3 animated-card-item">
                                    <h6>Document</h6>
                                    <a href="/download/aes/document/{{ $aes->user_id }}/{{ str_replace('/', '', $aes->document_key) }}" class="btn btn-primary btn-sm">Download</a>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-3 animated-card-item">
                                    <h6>Video</h6>
                                    <a href="/download/aes/video/{{ $aes->user_id }}/{{ str_replace('/', '', $aes->video_key) }}" class="btn btn-primary btn-sm">Download</a>
                                </div>
                                @endforeach
                            </div>

                            <!-- DES Section -->
                            <div class="section-header bg-gradient-des mt-5">
                                <h2 class="fw-bold text-uppercase gradient-text">DES</h2>
                                <h3 class="fw-bold text gradient-text">Data Encryption Standard</h3>
                            </div>
                            <hr class="mb-4">
                            <div class="row">
                                @foreach ($dess as $des)
                                <div class="col-12 col-md-6 col-lg-3 mb-3 animated-card-item">
                                    <h6 class="text-light"><strong>Full Name</strong></h6>
                                    <p class="text-light full-name">{{ $homeController->Desdecrypt($des->fullname, $des->key, $des->iv, 0) }}</p> <!-- Full name in white -->
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-3 animated-card-item">
                                    <h6>ID Card</h6>
                                    <a href="/download/des/id_card/{{ $des->user_id }}/{{ str_replace('/', '', $des->key) }}" class="btn btn-success btn-sm">Download</a>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-3 animated-card-item">
                                    <h6>Document</h6>
                                    <a href="/download/des/document/{{ $des->user_id }}/{{ str_replace('/', '', $des->key) }}" class="btn btn-success btn-sm">Download</a>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-3 animated-card-item">
                                    <h6>Video</h6>
                                    <a href="/download/des/video/{{ $des->user_id }}/{{ str_replace('/', '', $des->key) }}" class="btn btn-success btn-sm">Download</a>
                                </div>
                                @endforeach
                            </div>

                            <!-- RC4 Section -->
                            <div class="section-header bg-gradient-rc4 mt-5">
                                <h2 class="fw-bold text-uppercase gradient-text">RC4</h2>
                                <h3 class="fw-bold text gradient-text">Rivest Cipher 4</h3>
                            </div>
                            <hr class="mb-4">
                            <div class="row">
                                @foreach ($rc4s as $rc4)
                                <div class="col-12 col-md-6 col-lg-3 mb-3 animated-card-item">
                                    <h6 class="text-light"><strong>Full Name</strong></h6>
                                    <p class="text-light full-name">{{ $homeController->Rc4decrypt($rc4->fullname, $rc4->key, 0) }}</p> <!-- Full name in white -->
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-3 animated-card-item">
                                    <h6>ID Card</h6>
                                    <a href="/download/rc4/id_card/{{ $rc4->user_id }}/{{ str_replace('/', '', $rc4->key) }}" class="btn btn-secondary btn-sm">Download</a>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-3 animated-card-item">
                                    <h6>Document</h6>
                                    <a href="/download/rc4/document/{{ $rc4->user_id }}/{{ str_replace('/', '', $rc4->key) }}" class="btn btn-secondary btn-sm">Download</a>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-3 animated-card-item">
                                    <h6>Video</h6>
                                    <a href="/download/rc4/video/{{ $rc4->user_id }}/{{ str_replace('/', '', $rc4->key) }}" class="btn btn-secondary btn-sm">Download</a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="text-center">
            <img src="{{ url('img/mikulogin.gif') }}" alt="Profile Reminder GIF" class="img-fluid mb-4" style="max-width: 300px; height: auto;" />
            <h1 class="text-center display-5 fw-bold text-light gradient-text" style="margin-top: 20px;">Hi {{ Auth::user()->username }}, please complete your profile!</h1>
        </div>
    </div>
    @endif
</div>

<style>
    .username {
        color: black; /* Set username color to black */
        font-size: 1.5rem; /* Adjusted font size for better visibility */
        text-align: center; /* Centered the username */
        margin-top: 15px; /* Added margin for spacing */
    }

    .full-name {
        color: white; /* Set full name color to white */
    }

    .animated-card {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.5s forwards; /* Animation for card */
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

    .gradient-text {
        background: linear-gradient(135deg, #ffffff, #e0ffff); /* white to light cyan */
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .bg-gradient-aes {
        background: linear-gradient(135deg, #00bcd4, #424242); /* Cyan to Dark Grey */
        padding: 20px; /* Adding padding for visual separation */
    }

    .bg-gradient-des {
        background: linear-gradient(135deg, #00bcd4, #424242); /* Cyan to Dark Grey */
        padding: 20px; /* Adding padding for visual separation */
    }

    .bg-gradient-rc4 {
        background: linear-gradient(135deg, #00bcd4, #424242); /* Cyan to Dark Grey */
        padding: 20px; /* Adding padding for visual separation */
    }

    .btn-primary, .btn-secondary, .btn-success {
        background-color: #444;
        border-color: #444;
        transition: background-color 0.3s, transform 0.3s; /* Transition for hover effects */
    }

    .btn-primary:hover, .btn-secondary:hover, .btn-success:hover {
        background-color: #333;
        border-color: #333;
        transform: scale(1.05); /* Scale effect on hover */
    }

    /* Additional styles for better alignment */
    .card {
        margin: 0 auto; /* Center card horizontally */
    }
</style>

<script>
    // Assign animation delays for each animated-card-item
    document.querySelectorAll('.animated-card-item').forEach((item, index) => {
        item.style.setProperty('--delay', index);
        item.classList.add('animated');
    });
</script>
@endsection
