@extends('master') {{-- Extends the master layout --}}
@include('navbar') {{-- Includes the navbar section --}}
@php
$homeController = app('App\Http\Controllers\HomeController'); {{-- Instantiates HomeController --}}
@endphp

@section('content')
<div class="container">
    <div class="text-center mb-5" style="margin-top: 100px">
        <div class="col">
            <h1 class="text-center display-5 fw-bold" style="margin-top: 100px">{{$user->username}}'s fullname</h1>
            <br />
        </div>
    </div>

    <div id="mycard" class="d-flex justify-content-center">
        <div class="card mb-3 col-lg-6 mx-3">
            <div class="card-body">
                <div class="d-flex flex-column">
                    <div class="form-group mb-3 p-2">
                        <label class="fw-bold mb-3" style="font-size: 20px;">Decrypt key from your email</label>
                        <textarea id="encsymkey" rows="5" class="form-control" name="encsymkey"
                            placeholder="Enter the key from your email"></textarea>
                    </div>

                    <div class="d-flex justify-content-end mb-5">
                        <button id="submitButton1" class="btn btn-dark mx-2" type="button">Submit</button>
                    </div>

                    <div class="mb-3 p-2">
                        <label class="fw-bold mb-3" style="font-size: 20px;">Here is your symmetric key</label>
                        <textarea id="outputTextarea" class="form-control" rows="2" readonly></textarea>
                    </div>
                </div>
            </div>
        </div>

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

                    <div class="d-flex justify-content-end mb-5">
                        <button id="submitButton2" class="btn btn-dark mx-2" type="button">Submit</button>
                    </div>

                    {{-- Decrypt full name form --}}
                    <form action="/home/inbox/fullname/{{(int)$aesuser->user_id}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-5 p-2 d-flex justify-content-between align-items-center">
                            <label class="fw-bold mb-3" style="font-size: 20px;">Not requested yet?</label>
                            <button class="btn btn-dark" type="submit">Request</button>
                        </div>
                    </form>

                    {{-- Fullname output (hidden until authenticated) --}}
                    <div class="form-group mb-2 p-2 d-block visually-hidden" id="hiddendata">
                        <label class="fw-bold mb-2" style="font-size: 20px;">Here is {{$user->username}}'s fullname</label>
                        <p class="text-muted">{{ $homeController->AESdecrypt($aesuser->fullname, $aesuser->fullname_key, $aesuser->fullname_iv, 0) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Event listener for first submit button (decrypt key)
    document.getElementById('submitButton1').addEventListener('click', function () {
        var inputValue = document.getElementById('encsymkey').value;

        if (inputValue.trim() !== '') {
            $.ajax({
                url: '/home/data/fullname/{{(int)$aesuser->user_id}}',
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

    // Event listener for second submit button (symmetric key validation)
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
