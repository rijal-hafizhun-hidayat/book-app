@extends('layouts.guest')
@section('content')
    <form id="submitForm">
        <div class="form-floating mb-3">
            <input class="form-control" id="inputEmail" type="email" placeholder="name@example.com" />
            <label for="inputEmail">Email address</label>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="inputPassword" type="password" placeholder="Password" />
            <label for="inputPassword">Password</label>
        </div>
        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
            <button type="submit" class="btn btn-primary">login</button>
        </div>
    </form>
@endsection
@push('custom-script')
    <script>
        $('#submitForm').on('submit', function(e) {
            e.preventDefault();
            console.log(true)
        });
    </script>
@endpush
