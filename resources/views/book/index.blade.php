@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid px-4">
        <h1 class="my-4">Book</h1>
        @if ($errors->has('alert'))
            <div class="alert alert-danger" id="alert" role="alert">
                {{ $errors->first('alert') }}
            </div>
        @endif
        <form method="get" action="{{ route('book.index') }}">
            <div class="container mb-4">
                <div class="row">
                    <div class="col">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ request()->title }}"
                            id="inputTitle" aria-describedby="emailHelp">
                    </div>
                    <div class="col">
                        <label class="form-label">Author</label>
                        <select class="js-example-basic-multiple form-select" name="author[]" id="author"
                            multiple="multiple">
                            @foreach ($users as $user)
                                <option @if (request()->filled('author') && in_array($user->id, request()->author)) selected="selected" @endif
                                    value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label class="form-label">Book Category</label>
                        <select class="js-example-basic-multiple form-select" name="category[]" id="category"
                            multiple="multiple">
                            @foreach ($categories as $category)
                                <option @if (request()->filled('category') && in_array($category->id, request()->category)) selected="selected" @endif
                                    value="{{ $category->id }}">
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label class="form-label">Publisher</label>
                        <select class="js-example-basic-multiple form-select" name="publisher" id="publisher">
                            @foreach ($publishers as $publisher)
                                <option @selected(request()->filled('publisher') && $publisher->id == request()->publisher) value="{{ $publisher->id }}">
                                    {{ $publisher->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary mt-4">search</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Data Book
                @if (Auth::user()->UserRole->role_id === 1)
                    <a href="{{ route('book.create') }}">Add Book</a>
                @endif
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Author</th>
                            <th scope="col">Background</th>
                            <th scope="col">Book Category</th>
                            <th scope="col">Book Publisher</th>
                            <th scope="col">Cover</th>
                            @if (Auth::user()->UserRole->role_id === 1)
                                <th scope="col">Action</th>
                            @endif

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $book->title }}</td>
                                <td>
                                    @foreach ($book->bookWriter as $writer)
                                        <span class="badge text-bg-secondary">{{ $writer->user->name }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $book->background }}</td>
                                <td>
                                    @foreach ($book->bookCategory as $bookCategory)
                                        <span class="badge text-bg-secondary">{{ $bookCategory->category->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <span
                                        class="badge text-bg-secondary">{{ $book->bookPublisher->publisher->name }}</span>
                                </td>
                                <td>
                                    <img class="img-thumbnail" src="{{ Storage::url($book->cover) }}" alt="">
                                </td>
                                @if (Auth::user()->UserRole->role_id === 1)
                                    <td>
                                        <div class="d-flex justify-content-start">
                                            <div>
                                                <a href="{{ route('book.show', ['id' => $book->id]) }}"
                                                    class="btn btn-warning">Update</a>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-danger destroyBook"
                                                    id="{{ $book->id }}">Hapus</button>
                                            </div>
                                        </div>
                                    </td>
                                @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('custom-script')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
        $('.destroyBook').on('click', function() {
            let bookId = parseInt(this.id)
            $.ajax({
                type: "delete",
                url: `/book/${bookId}`,
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
                    console.log(error)
                }
            });
        });
    </script>
@endpush
