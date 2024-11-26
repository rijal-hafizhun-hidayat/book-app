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
                <form method="post">
                    <div class="container">
                        <div class="row">
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
                                <label class="form-label">Category</label>
                                <select class="js-example-basic-multiple form-select" name="category" id="category">
                                    @foreach ($categories as $category)
                                        <option @selected(request()->filled('category') && $category->id == request()->category) value="{{ $category->id }}">
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
