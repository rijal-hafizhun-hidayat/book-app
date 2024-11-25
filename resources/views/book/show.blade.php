@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid px-4">
        <div class="alert alert-danger" hidden id="alert" role="alert">

        </div>
        <h1 class="my-4">Update Book</h1>
        <div class="card mb-4">
            <div class="card-header">
                Update Data Book
            </div>
            <div class="card-body">
                <form id="submitForm">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $book->title }}"
                            id="inputTitle" aria-describedby="emailHelp">
                        <div class="text-danger" id="errorTitle"></div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Author</label>
                        <select class="js-example-basic-multiple form-select" name="author[]" id="author"
                            multiple="multiple">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <div class="text-danger" id="errorAuthor"></div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Background Story</label>
                        <textarea class="form-control" placeholder="background story" name="background" id="inputBackground">{{ $book->background }}</textarea>
                        <div class="text-danger" id="errorBackground"></div>
                    </div>
                    <div class="mb-3">
                        <label for="inputCategory" class="form-label">Book Category</label>
                        <select class="js-example-basic-multiple form-select" name="category[]" id="category"
                            multiple="multiple">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="text-danger" id="errorCategory"></div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Publisher</label>
                        <select class="form-select" name="publisher" id="inputPublisher"
                            aria-label="Default select example">
                            @foreach ($publishers as $publisher)
                                <option @selected($book->bookPublisher->publisher->id === $publisher->id) value="{{ $publisher->id }}">{{ $publisher->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="text-danger" id="errorPublisher"></div>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Upload Book Cover</label>
                        <input class="form-control" type="file" name="cover" id="uploadCover">
                        <div class="text-danger" id="errorCover"></div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" id="submitButton" class="btn btn-primary">submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('custom-script')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });

        $('#submitForm').on('submit', function(e) {
            $('#alert').attr('hidden', true);
            $('#errorTitle').text('');
            $('#errorAuthor').text('');
            $('#errorBackground').text('');
            $('#errorCategory').text('');
            $('#errorCover').text('');
            $('#errorPublisher').text('');

            e.preventDefault();
            const formData = new FormData(this)
            let bookId = parseInt({{ $book->id }})
            $.ajax({
                type: "post",
                url: `/api/book/${bookId}/update`,
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    Authorization: 'Bearer ' + sessionStorage.getItem('token'),
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire({
                        title: "success",
                        text: `${response.message}`,
                        icon: "success"
                    });
                    window.location.href = "{{ route('book.index') }}";
                },
                error: function(error) {
                    if (error && error.status === 422) {
                        const err = error.responseJSON
                        if (err.errors.title) {
                            $('#errorTitle').text(err.errors.title[0]);
                        }
                        if (err.errors.author) {
                            $('#errorAuthor').text(err.errors.author[0]);
                        }
                        if (err.errors.background) {
                            $('#errorBackground').text(err.errors.background[0]);
                        }
                        if (err.errors.category) {
                            $('#errorCategory').text(err.errors.category[0]);
                        }
                        if (err.errors.cover) {
                            $('#errorCover').text(err.errors.cover[0]);
                        }
                        if (err.errors.publisher) {
                            $('#errorPublisher').text(err.errors.publisher[0]);
                        }
                    } else {
                        const err = error.responseJSON
                        $('#alert').text(err.message);
                        $('#alert').removeAttr('hidden');
                    }
                }
            });
        });
    </script>
@endpush
