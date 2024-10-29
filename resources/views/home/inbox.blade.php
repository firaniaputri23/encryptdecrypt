@extends('master') 
@include('navbar')
@section('content')
<div class="container">
    <div class="text-center mb-5" style="margin-top: 100px">
        <!-- Center the content with a title -->
        <div class="col">
            <h1 class="display-4 fw-bolder mb-4">Inboxes</h1>
            <br />
        </div>
    </div>

    <div id="mycard">
        @foreach($inboxes as $inbox)
        <div class="card mb-3 p-3 shadow-sm" style="border-radius: 10px;">
            <div class="card-body d-flex align-items-center">
                <!-- Avatar Picture -->
                <div class="me-4">
                    <img src="{{ asset('img/mikulogin.gif') }}" alt="Miku Avatar" class="rounded-circle" style="width: 80px; height: 80px;">
                </div>

                <!-- Inbox Details -->
                <div class="row flex-fill">
                    <div class="col-sm-6 d-flex flex-column justify-content-center">
                        <h4 class="fw-bold mb-1">{{$inbox->clientUser->username}}</h4>
                        <small class="text-muted">Inbox Type: {{$inbox->type}}</small>
                    </div>
                    
                    <div class="col-sm-6 d-flex justify-content-end align-items-center">
                        <form action="{{ route('mail.'.$inbox->type, ['main_key' => $inbox->mainUser->id, 'client_key' => $inbox->clientUser->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <button type="submit" class="btn btn-success">Accept</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <script>
        $(document).ready(function () {
            $("#filter").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#mycard > div").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
</div>
@endsection
