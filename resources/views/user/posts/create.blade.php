@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
    <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        {{-- CATEGORIES --}}
        <label for="categories" class="form-label fw-bold">Category <span class="fw-light">( up to 3 )</span></label>
        <div>
            {{-- <input type="checkbox" name="categories[]" id="" class="form-check-input" value="">
            <label for="" class="form-check-label">Travel</label> --}}
            {{-- LOOP --}}
            @forelse ($all_categories as $category)
                <div class="form-check form-check-inline">
                    <input type="checkbox" name="categories[]" id="{{ $category->name }}" class="form-check-input" value="{{ $category->id }}">
                    <label for="{{ $category->name }}" class="form-check-label">{{ $category->name }}</label>
                </div>
            @empty
                <span class="font-italic">No categories yet.</span>
            @endforelse

            {{-- ERROR MESSAGE FOR CATEGORIES --}}
            @error('categories')
                <p class="mb-0 text-danger small">{{ $message }}</p>
            @enderror
        </div>

        {{-- CAPTION --}}
        <label for="description" class="form-label fw-bold mt-3">Description</label>
        <textarea name="description" id="description" rows="3" placeholder="What's on your mind" class="form-control">{{ old('description') }}</textarea>

        {{-- ERROR MESSAGE FOR CAPTION --}}
        @error('description')
         <p class="mb-0 text-danger small">{{ $message }}</p>
        @enderror

        {{-- IMAGE --}}
        <label for="image" class="form-label fw-bold mt-3">Image</label>
        <input type="file" name="image" id="image" class="form-control">
        <p class="form-text">
            Acceptable formats: jpeg, jpg, png, gif only <br>
            Max siza is 1048kb
        </p>

        {{-- ERROR MESSAGE FOR IMAGE--}}
        @error('image')
            <p class="mb-0 text-danger small">{{ $message }}</p>
        @enderror

        {{-- ACTION BUTTON --}}
        <button type="submit" class="btn btn-primary px-4mt-4">Post</button>
    </form>
@endsection
