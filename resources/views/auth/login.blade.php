@extends('layouts.guest')
@section('content')
    <div class="alert alert-danger" hidden id="alert" role="alert">

    </div>
    <div class="alert alert-success" hidden id="success" role="alert">
    </div>
    <form id="submitForm">
        <div class="form-floating mb-3">
            <input class="form-control" id="inputEmail" type="email" placeholder="name@example.com" />
            <label for="inputEmail">Email address</label>
            <div class="text-danger" id="errorEmail"></div>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="inputPassword" type="password" placeholder="Password" />
            <label for="inputPassword">Password</label>
            <div class="text-danger" id="errorPassword"></div>
        </div>
        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
            <button type="submit" id="buttonSubmit" class="btn btn-primary">login</button>
        </div>
    </form>
@endsection
@push('custom-script')
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
@endpush
