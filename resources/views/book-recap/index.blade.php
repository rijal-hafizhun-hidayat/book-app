@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid px-4">
        <h1 class="my-4">Book Recap</h1>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Data Book Recap
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('book-recap.export') }}">
                    @csrf
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <label class="form-label">Writer</label>
                                <select class="js-example-basic-multiple form-select" name="user_id" id="writer">
                                    <option selected value="">all</option>
                                    @foreach ($users as $user)
                                        <option @selected(request()->filled('user_id') && $user->id == request()->user_id) value="{{ $user->id }}">
                                            {{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label">Publisher</label>
                                <select class="js-example-basic-multiple form-select" name="publisher_id" id="publisher">
                                    <option selected value="">all</option>
                                    @foreach ($publishers as $publisher)
                                        <option @selected(request()->filled('publisher_id') && $publisher->id == request()->publisher_id) value="{{ $publisher->id }}">
                                            {{ $publisher->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label">Category</label>
                                <select class="js-example-basic-multiple form-select" name="category_id" id="category">
                                    <option selected value="">all</option>
                                    @foreach ($categories as $category)
                                        <option @selected(request()->filled('category_id') && $category->id == request()->category_id) value="{{ $category->id }}">
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary mt-4">recap</button>
                            </div>
                        </div>
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
    </script>
@endpush
