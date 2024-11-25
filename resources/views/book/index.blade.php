@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid px-4">
        <h1 class="my-4">Book</h1>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Data Book
                <a href="{{ route('book.create') }}">Add Book</a>
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
                            <th scope="col">Cover</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->background }}</td>
                                <td>
                                    @foreach ($book->bookCategory as $bookCategory)
                                        <span class="badge text-bg-secondary">{{ $bookCategory->category->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <img class="img-thumbnail" src="{{ Storage::url($book->cover) }}" alt="">
                                </td>
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
        $('.destroyBook').on('click', function() {
            let bookId = parseInt(this.id)
            $.ajax({
                type: "delete",
                url: `/api/book/${bookId}`,
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
