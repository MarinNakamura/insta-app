@extends('layouts.app')

@section('title', 'Admin: Categories')

@section('content')
        <form action="{{ route('admin.categories.store') }}" method="post" class="row gx-2 mb-4">
            @csrf
            <div class="col-4">
                <input type="text" name="add_category" id="add_category" class="form-control" placeholder="Add a category...">
                @error('add_category')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-auto">
                <button class="btn btn-control btn-primary">+ Add</button>
            </div>
        </form>

        <table class="table border table-hover align-middle bg-white text-secondary">
            <thead class="table-warning text-secondary text-uppercase small text-center">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Count</th>
                    <th>Last updated</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($all_categories as $category)
                    <tr class="text-center">
                        {{-- ID --}}
                        <td>{{ $category->id }}</td>
                        <td class="fw-bold text-dark">{{ $category->name }}</td>
                        <td>{{ $category->categoryPosts()->count() }}</td>
                        <td>{{ $category->updated_at }}</td>
                        <td>
                            <button class="btn btn-outline-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#edit-category{{ $category->id }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-category{{ $category->id }}">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                    @include('admin.categories.actions')
                @empty
                    <tr>
                        <td class="text-center" colspan="5">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $all_categories->links() }}
@endsection
