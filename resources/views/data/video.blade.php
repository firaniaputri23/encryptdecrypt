@extends('master') {{-- Extends the master layout --}}
@include('navbar') {{-- Includes the navbar section --}}
@php
$homeController = app('App\Http\Controllers\HomeController'); {{-- Instantiates HomeController --}}
@endphp

@section('content')
<div class="container">
    <div class="text-center mb-5" style="margin-top: 100px">
        <div class="col">
            <h1 class="text-center display-5 fw-bold" style="margin-top: 100px">{{$user->username}}'s Video</h1>
            <br />
        </div>
    </div>

    <div id="mycard" class="d-flex justify-content-center">
        <div class="card mb-3 col-lg-6 mx-3">
            <div class="card-body">
                <div class="d-flex flex-column">
                    {{-- Decrypt key input --}}
                    <div class="form-group mb-3 p-2">
                        <label class="fw-bold mb-3" style="font-size: 20px;">Decrypt key from your email</label>
                        <textarea id="encsymkey" rows="5" class="form-control" name="encsymkey"
                            placeholder="Enter the key from your email"></textarea>
                    </div>

                    {{-- Submit button for decrypting key --}}
                    <div class="d-flex justify-content-end mb-5">
                        <button id="submitButton1" class="btn btn-dark mx-2" type="button">Submit</button>
                    </div>

                    {{-- Output of decrypted symmetric key --}}
                    <div class="mb-3 p-2">
                        <label class="fw-bold mb-3" style="font-size: 20px;">Here is your symmetric key</label>
                        <textarea id="outputTextarea" class="form-control" rows="2" readonly></textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Symmetric key validation and video request form --}}
        <div class="card mb-3 col-lg-5 mx-3">
            <div class="card-body">
                <div class="d-flex flex-column">
                    <div class="form-group mb-3 p-2">
                        <label class="fw-bold mb-3" style="font-size: 20px;">Symmetric Key</label>
                        @if($inbox !== null)
                        <input type="hidden" class="form-control" id="realsymkey" value="{{$inbox->sym_key}}">
                        @endif
                        <textarea id="symkey" rows="5" class="form-control" name="symkey"
                            placeholder="Enter the symmetric key"></textarea>
                    </div>

                    {{-- Submit button to verify symmetric key --}}
                    <div class="d-flex justify-content-end mb-5">
                        <button id="submitButton2" class="btn btn-dark mx-2" type="button">Submit</button>
                    </div>

                    {{-- Video request form if key not yet requested --}}
                    <form action="/home/inbox/video/{{(int)$aesuser->user_id}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-5 p-2 d-flex justify-content-between align-items-center">
                            <label class="fw-bold mb-3" style="font-size: 20px;">Not requested yet?</label>
                            <button class="btn btn-dark" type="submit">Request</button>
                        </div>
                    </form>

                    {{-- Video download section (hidden until authenticated) --}}
                    <div class="form-group mb-2 p-2 d-block visually-hidden" id="hiddendata">
                        <label class="fw-bold mb-2" style="font-size: 20px;">Here is {{$user->username}}'s Video</label>
                        @php
                        $ckey = null;

                        if ($inbox !== null) {
                            $ckey = str_replace('/', '', $inbox->sym_key);
                        }
                        @endphp

                        @if($ckey !== null)
                        <a href="/download/aes/video/{{ $aesuser->user_id }}/{{ $ckey }}"
                            class="btn btn-primary btn-sm">
                            Download
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Decryption key submission handler
    document.getElementById('submitButton1').addEventListener('click', function () {
        var inputValue = document.getElementById('encsymkey').value;

        if (inputValue.trim() !== '') {
            $.ajax({
                url: '/home/data/video/{{$user->id}}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    encsymkey: inputValue
                },
                success: function (response) {
                    document.getElementById('outputTextarea').value = response.decrypted;
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    });

    // Symmetric key validation and hidden content toggle
    document.getElementById('submitButton2').addEventListener('click', function () {
        var inputValue = document.getElementById('symkey').value;
        var realsymkey = document.getElementById('realsymkey').value;
        var hiddenDataDiv = document.getElementById('hiddendata');

        if (inputValue === realsymkey) {
            hiddenDataDiv.classList.remove('visually-hidden');
        } else {
            hiddenDataDiv.classList.add('visually-hidden');
        }
    });
</script>
@endsection
