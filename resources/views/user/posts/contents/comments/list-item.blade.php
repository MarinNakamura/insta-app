{{-- user name & comment body --}}
<div class="mb-2">
    <a href="{{ route('profile.show', $comment->user_id) }}"
        class="text-decoration-none text-dark fw-bold">{{ $comment->user->name }}</a>
    &nbsp;
    <span class="fw-light">{{ $comment->body }}</span>

    <div>
        {{-- date --}}
        <span class="text-muted xsmall">{{ date('D, M d Y', strtotime($comment->created_at)) }}</span>

        @if ($comment->user_id == Auth::user()->id)
            &middot;
            <form action="{{ route('comment.destroy', $comment->id) }}" method="post" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-transparent p-0 border-0 shadow-none text-danger small">Delete</button>
            </form>
        @endif
    </div>
</div>
