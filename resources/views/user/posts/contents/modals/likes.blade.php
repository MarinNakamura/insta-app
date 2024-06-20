{{-- <div class="modal fade" id="show-user{{ $post->likes->user->name }}"> --}}
<div class="modal fade" id="show-user{{ $post->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-secondary">

        <div class="modal-header border-0">
            {{-- <div class="row justify-content-end"> --}}
                {{-- <div class="col-auto"> --}}
                    <button type="button" data-bs-dismiss="modal" class="border-0 text-primary fw-bold bg-transparent ms-auto">x</button>
                {{-- </div> --}}
            {{-- </div> --}}
        </div>

            <div class="modal-body">
                <div class="row justify-content-center">
                    {{-- <div class="col-auto"> --}}
                    {{-- <ul> --}}
                    <div class="col-8">
                        @foreach ($post->likes as $like)
                                <div class="row align-items-center mb-3">
                                    <div class="col-auto">
                                        {{-- <li class="d-flex"> --}}
                                        @if ($like->user->avatar)
                                            <img src="{{ $like->user->avatar }}" alt="" class="rounded-circle avatar-sm d-inline">
                                        @else
                                            <i class="fa-solid fa-circle-user text-secondary icon-sm align-middle"></i>
                                        @endif
                                        <span class="fw-bold">{{ $like->user->name }}</span>
                                        {{-- </li> --}}
                                    </div>

                                    <div class="col-auto">
                                        @if ($like->user->id == Auth::user()->id)

                                            @if ($like->user->isFollowing())
                                                {{-- following / unfollow  --}}
                                                <form action="{{ route('follow.destroy', $like->user->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn p-0 text-outline-secondary">Following</button>
                                                </form>
                                            @else
                                                {{-- follow --}}
                                                <form action="{{ route('follow.store', $like->user->id) }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn p-0 text-primary">Follow</button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                    </div>
                    {{-- </ul> --}}
                    {{-- </div> --}}
                </div>

            </div>
        </div>
    </div>
</div>
