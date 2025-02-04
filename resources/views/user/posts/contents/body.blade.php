<div class="row align-items-center">
    <div class="col-auto">
        {{-- like/heart button --}}
        @if ($post->isLiked())
            {{-- unlike(red) button --}}
            <form action="{{ route('like.destroy', $post->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-transparent border-0 shadow-none p-0">
                    <i class="fa-solid fa-heart text-danger"></i>
                </button>
            </form>
        @else
            <form action="{{ route('like.store', $post->id) }}" method="post">
                @csrf
                <button type="submit" class="bg-transparent border-0 shadow-none p-0">
                    <i class="fa-regular fa-heart"></i>
                </button>
            </form>
        @endif
    </div>

    <div class="col-auto px-0">
        {{-- no. of likes --}}
        {{-- <a data-bs-toggle="modal" data-bs-target="#show-user{{$post->likes->user->name}}">{{ $post->likes->count() }} --}}
    @if ($post->likes->count()>0)
        <button data-bs-toggle="modal" data-bs-target="#show-user{{ $post->id }}" class="bg-transparent p-0 border-0 shadow-none">{{ $post->likes->count() }}</button>
        @include('user.posts.contents.modals.likes')
    @else
        0
    @endif
    </div>

    <div class="col text-end">
        {{-- categories --}}
        @forelse ($post->categoryPosts as $category_post)
            <div class="badge bg-secondary bg-opacity-50">{{ $category_post->category->name }}</div>
        @empty
            <div class="badge bg-dark">Uncategorized</div>
        @endforelse
    </div>
</div>

{{-- post owner & description --}}
<a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $post->user->name }}</a>
&nbsp;
<span class="fw-light">{{ $post->description }}</span>

{{-- date --}}
<p class="text-uppercase text-muted xsmall">{{ date('M d, Y', strtotime($post->created_at)) }}</p>
