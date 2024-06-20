@extends('layouts.app')

@section('title', 'Admin: Posts')

@section('content')
    <div class="row">
        <div class="col-10"></div>
        <div class="mb-3 col-2">
            @auth
                <form action="{{ route('admin.posts') }}" method="get">
                    <input type="text" name="search" placeholder="search posts..." class="form-control" value="{{ $search }}">
                </form>
            @endauth
        </div>
    </div>
    <table class="table border table-hover align-middle bg-white text-secondary">
        <thead class="table-primary text-secondary text-uppercase small">
            <tr>
                <th></th>
                <th></th>
                <th>Category</th>
                <th>Owner</th>
                <th>Created At</th>
                <th>status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($all_posts as $post)
                <tr>
                    {{-- ID --}}
                    <td>{{ $post->id }}</td>

                    {{-- Picture --}}
                    <td>
                        <a href="{{ route('post.show', $post->id) }}">
                            <img src="{{ $post->image }}" alt="" class="image-lg d-block mx-auto">
                        </a>
                    </td>

                    {{-- category --}}
                    <td>
                        @forelse ($post->categoryPosts as $category_post)
                            <div class="badge bg-secondary bg-opacity-50">{{ $category_post->category->name }}</div>
                        @empty
                            <div class="badge bg-dark">Uncategorized</div>
                        @endforelse
                    </td>

                    {{-- Owner --}}
                    <td>
                        <a href="{{ route('profile.show', $post->user_id) }}"
                            class="text-decoration-none fw-bold text-dark">{{ $post->user->name }}</a>
                    </td>

                    {{-- created at --}}
                    <td>{{ $post->created_at }}</td>

                    {{-- status --}}
                    <td>
                        @if ($post->trashed())
                            <i class="fa-solid fa-circle-minus"></i> Hidden
                        @else
                            <i class="fa-solid fa-circle text-primary"></i> Visible
                        @endif
                    </td>

                    {{-- Menu --}}
                    <td>
                        @if ($post->user->id != Auth::user()->id)
                            <div class="dropdown">
                                <button class="btn btn-sm" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>

                                <div class="dropdown-menu">
                                    @if ($post->trashed())
                                        {{-- Visisblize --}}
                                        <button class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#unhide-post{{ $post->id }}">
                                            <i class="fa-solid fa-eye"></i> Unhide Post {{ $post->id }}
                                        </button>
                                    @else
                                        {{-- Hide --}}
                                        <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                            data-bs-target="#hide-post{{ $post->id }}">
                                            <i class="fa-solid fa-eye-slash"></i> Hide Post {{ $post->id }}
                                        </button>
                                    @endif
                                </div>

                            </div>
                            @include('admin.posts.actions')
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="7">No posts found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $all_posts->links() }}
@endsection
