@extends('master')
@include('navbar')
@php
$homeController = app('App\Http\Controllers\HomeController');
@endphp
@section('content')
<div class="container" style="background: linear-gradient(270deg, #00bcd4, #000000); color: #e0e0e0; border-radius: 8px; padding: 20px;">
    <div class="text-center mb-5" style="margin-top: 100px;">
        <div class="col">
            <h1 class="text-center display-5 fw-bold" style="background: linear-gradient(135deg, #00bcd4, #000000); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                {{$user->username}}'s Document
            </h1>
            <br />
        </div>
    </div>

    <div id="mycard" class="d-flex justify-content-center">
        <div class="card mb-3 col-lg-6 mx-3 bg-dark text-light glow-on-hover">
            <div class="card-body">
                <div class="form-group mb-3 p-2">
                    <label class="fw-bold mb-3" style="font-size: 20px; color: #00bcd4;">Decrypt key from your email</label>
                    <textarea id="encsymkey" rows="5" class="form-control" name="encsymkey" placeholder="Enter the key from your email" value=""></textarea>
                </div>

                <div class="d-flex justify-content-end mb-5">
                    <button id="submitButton1" class="btn btn-dark glow-on-hover" type="submit">Submit</button>
                </div>

                <div class="mb-3 p-2">
                    <label class="fw-bold mb-3" style="font-size: 20px; color: #00bcd4;">Here is your symmetric key</label>
                    <textarea id="outputTextarea" class="form-control" rows="2" readonly></textarea>
                </div>
            </div>
        </div>
        <!-- Second Card -->
        <div class="card mb-3 col-lg-5 mx-3 bg-dark text-light glow-on-hover">
            <div class="card-body">
                <div class="form-group mb-3 p-2">
                    <label class="fw-bold mb-3" style="font-size: 20px; color: #00bcd4;">Symmetric Key</label>
                    @if($inbox !== null)
                    <input type="hidden" class="form-control" id="realsymkey" value="{{$inbox->sym_key}}">
                    @endif
                    <textarea id="symkey" rows="5" class="form-control" name="symkey" placeholder="Enter the symmetric key" value=""></textarea>
                </div>

                <div class="d-flex justify-content-end mb-5">
                    <button id="submitButton2" class="btn btn-dark glow-on-hover" type="submit">Submit</button>
                </div>

                <form action="/home/inbox/document/{{(int)$aesuser->user_id}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-5 p-2 d-flex justify-content-between align-items-center">
                        <label class="fw-bold mb-3" style="font-size: 20px; color: #00bcd4;">Not requested yet?</label>
                        <button class="btn btn-dark glow-on-hover" type="submit">Request</button>
                    </div>
                </form>

                <div class="form-group mb-2 p-2 d-block visually-hidden" id="hiddendata">
                    <label class="fw-bold mb-2" style="font-size: 20px; color: #00bcd4;">Here is {{$user->username}}'s document</label>
                    @if($bkey !== null)
                    <a href="/download/aes/document/{{ $aesuser->user_id }}/{{ $bkey }}" class="btn btn-primary glow-on-hover">Download</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript handlers
</script>
@endsection

<style>
    /* Button Glow */
    .glow-on-hover {
        transition: box-shadow 0.3s ease;
        background-color: #1e1e1e;
        color: #fff;
    }
    .glow-on-hover:hover {
        box-shadow: 0 0 20px rgba(0, 188, 212, 0.5), 0 0 30px rgba(0, 188, 212, 0.3);
    }
</style>
