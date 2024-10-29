@extends('master') 
@include('navbar')
@section('content')
    <div class="hero-section d-flex align-items-center justify-content-center">
        <div class="container text-center">
            <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInDown" style="background: linear-gradient(135deg, #00bcd4, #000000); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                "This is Encryption and Decryption."
            </h1>
            <p class="lead mb-5 animate__animated animate__fadeInUp" style="max-width: 1200px; margin: 0 auto; color: #e0e0e0; font-size: 1.5rem; font-style: bold;">
                In a world where data security is paramount, safeguarding your sensitive documents has never been more crucial. Introducing our AES Encryption Tool—your ultimate solution for protecting your PDFs, JPGs, and MP4 files with state-of-the-art encryption technology!
            </p>
            <div class="features mb-5 animate__animated animate__fadeInUp">
                <h7 class="display-5 fw-bold text-light mb-4">Why Choose Our AES Encryption Tool?</h7>
                <div class="row justify-content-center mt-4">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card text-center bg-dark text-light glow-on-hover" style="height: 100%;">
                            <div class="card-body">
                                <span class="icon" style="font-size: 3rem;">🔒</span>
                                <h4 class="card-title mt-3"><strong>Unmatched Security</strong></h4>
                                <p class="card-text">Your files are encrypted with military-grade AES technology, ensuring only you and trusted individuals can access them.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card text-center bg-dark text-light glow-on-hover" style="height: 100%;">
                            <div class="card-body">
                                <span class="icon" style="font-size: 3rem;">📄</span>
                                <h4 class="card-title mt-3"><strong>Versatile File Support</strong></h4>
                                <p class="card-text">Seamlessly encrypt PDFs, images, and videos—keeping your memories and data safe.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card text-center bg-dark text-light glow-on-hover" style="height: 100%;">
                            <div class="card-body">
                                <span class="icon" style="font-size: 3rem;">⚡</span>
                                <h4 class="card-title mt-3"><strong>User-Friendly Interface</strong></h4>
                                <p class="card-text">Encrypt files in just a few clicks—no tech skills required!</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card text-center bg-dark text-light glow-on-hover" style="height: 100%;">
                            <div class="card-body">
                                <span class="icon" style="font-size: 3rem;">🌐</span>
                                <h4 class="card-title mt-3"><strong>Access Anywhere</strong></h4>
                                <p class="card-text">Encrypt your files from anywhere, at any time—it's that simple!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="join-users animate__animated animate__fadeInUp">
                <h3 class="text-light"><strong>Get Free Udemy Course to Mastering Cryptography!</strong></h3>
                <h5 class="text-light spacing">Powered by ITS Nabu - Networking Technologies and Intelligent Cyber Security (NETICS) Laboratory of the ITS Informatics Department</h5>
                <a href="https://www.udemy.com/course/its-keamanan-informasi/?couponCode=CE33BDD5213E2CBCCD0B" class="btn btn-dark shadow animate__animated animate__zoomIn position-relative learn-more" target="_blank">
                    Learn More
        <span class="rainbow-light"></span>
    </a>
</div>
@endsection
<style>
    .hero-section {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        background: linear-gradient(270deg, #00bcd4, #000000); /* Cyan blue and black gradient */
        background-size: 300% 300%;
        animation: gradientBackground 10s ease infinite;
    }
    @keyframes gradientBackground {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }
    .rainbow-light {
        content: "";
        position: absolute;
        left: 50%;
        bottom: -5px; /* Adjust this value to position the light */
        width: 100%;
        height: 8px; /* Height of the light effect */
        background: rgba(255, 255, 255, 0.5); /* Light white background for glow effect */
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.7); /* Add glow effect */
        animation: glow 1.5s linear infinite; /* Animation effect */
        border-radius: 5px;
        transform: translateX(-50%); /* Center the effect */
    }
    @keyframes glow {
        0% {
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.5); /* Starting glow */
        }
        50% {
            box-shadow: 0 0 40px rgba(255, 255, 255, 0.8); /* Brightest glow */
        }
        100% {
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.5); /* Return to starting glow */
        }
    }
    .learn-more {
        font-weight: bold; /* Ensure the title is bold */
        margin-bottom: 20px; /* Space below the button */
        padding: 30px 50px; /* Increase padding for a larger button */
        font-size: 1.75rem; /* Increase font size for better visibility */
        border-radius: 10px; /* Make the corners rounded */
        transition: background-color 0.3s, transform 0.3s; /* Add smooth transitions */
        display: inline-block; /* Ensure the button respects padding */
    }
    .btn-dark {
        font-weight: bold; /* Ensure the title is bold */
        background-color: #1e1e1e; /* Dark background for the button */
        color: #fff; /* White text color for contrast */
        border: none; /* Remove border */
        transition: background-color 0.3s, box-shadow 0.3s; /* Transition effects */
        position: relative;
        z-index: 1; /* Make sure button is above the glow */
    }
    .btn-dark:hover {
        font-weight: bold; /* Ensure the title is bold */
        background-color: #333; /* Slightly lighter on hover */
        box-shadow: 0 0 15px rgba(0, 188, 212, 0.5), 0 0 30px rgba(0, 188, 212, 0.3); /* Cyan glow on hover */
        transform: scale(1.05); /* Slightly enlarge button on hover */
    }
    .glow-on-hover {
        transition: box-shadow 0.3s ease;
    }
    .glow-on-hover:hover {
        font-weight: bold; /* Ensure the title is bold */
        box-shadow: 0 0 20px rgba(0, 188, 212, 0.5), 0 0 30px rgba(0, 188, 212, 0.3); /* Glow effect on hover */
        transform: scale(1.05); /* Slightly enlarge the card on hover */
    }
</style>
