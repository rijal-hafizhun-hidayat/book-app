@extends('layouts.guest')
@section('content')
    @if ($errors->has('alert'))
        <div class="alert alert-danger" id="alert" role="alert">
            {{ $errors->first('alert') }}
        </div>
    @endif
    <form id="submitForm" method="post" action="{{ route('login') }}">
        @csrf
        <div class="form-floating mb-3">
            <input class="form-control" id="inputEmail" type="email" name="email" placeholder="name@example.com" />
            <label for="inputEmail">Email address</label>
            @if ($errors->has('email'))
                <div class="text-danger">
                    {{ $errors->first('email') }}
                </div>
            @endif
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Password" />
            <label for="inputPassword">Password</label>
            @if ($errors->has('password'))
                <div class="text-danger">
                    {{ $errors->first('password') }}
                </div>
            @endif
        </div>
        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
            <button type="submit" id="buttonSubmit" class="btn btn-primary">login</button>
        </div>
    </form>
@endsection
{{-- @push('custom-script')
    <script>
        $('#submitForm').on('submit', function(e) {
            e.preventDefault();
            $('#errorEmail').text('');
            $('#errorPassword').text('');
            $('#buttonSubmit').attr('disabled', true);
            $('#alert').attr('hidden', true);
            $('#success').attr('hidden', true);

            $.ajax({
                type: "post",
                url: "{{ route('api.auth.login') }}",
                data: {
                    email: $('#inputEmail').val(),
                    password: $('#inputPassword').val()
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response)
                    $('#success').text(response.message);
                    $('#success').removeAttr('hidden');
                    $('#buttonSubmit').removeAttr('disabled');
                    sessionStorage.setItem("token", response.token);

                    window.location.href = "{{ route('book.index') }}"
                },
                error: function(error) {
                    console.log(error)
                    if (error && error.status === 422) {
                        const err = error.responseJSON
                        if (err.errors.email) {
                            $('#errorEmail').text(err.errors.email[0]);
                        }
                        if (err.errors.password) {
                            $('#errorPassword').text(err.errors.password[0]);
                        }
                    } else if (error && error.status === 401) {
                        const err = error.responseJSON
                        $('#alert').text(err.message);
                        $('#alert').removeAttr('hidden');
                    }

                    $('#buttonSubmit').removeAttr('disabled');
                }
            });
        });
    </script>
@endpush --}}
