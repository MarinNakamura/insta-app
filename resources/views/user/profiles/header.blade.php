<div class="row mb-5">
    <div class="col-4">
    {{-- Profile Icon --}}
        @if ($user->avatar)
        <button type="button" class="border-0 btn btn-transparent" data-bs-toggle="modal" data-bs-target="#recent-comment{{ $user->id }}">
            <img src="{{ $user->avatar }}" alt="" class="rounded-circle image-lg d-block mx-auto">
        </button>
        @else
        <button type="button" class="border-0 btn btn-transparent" data-bs-toggle="modal" data-bs-target="#recent-comment{{ $user->id }}">
            <i class=" fa-solid fa-circle-user icon-lg text-secondary d-block text-center"></i>
        </button>
        @endif
    </div>

    {{-- pop out window for recent comments --}}
    <style>
        .modal-body {
            max-height: 350px;
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="recent-comment{{ $user->id }}">
        <div class="modal-dialog">
        {{-- <div class="modal-dialog modal-dialog-scrollable"> --}}
          <div class="modal-content border-secondary">
            <div class="modal-header border-secondary">
              <h4 class="h5 text-secondary">Recent Comments</h4>
            </div>

            <div class="modal-body">
               @if ($user->comments->count() != 0)
                   @foreach ($user->comments->take(5) as $comment)
                       <div class="container mb-2">
                            <div class="card border border-primary">
                                <div class="card-body border-secondary pb-0">
                                    <p class="text-muted mb-0">{{ $comment->body }}</p>
                                </div>

                                <hr class="">

                                <div class="card-footer border-0 pb-0 bg-white">
                                    <p class="text-muted">Replied to <a href="{{ route('post.show', $comment->post) }}" class="text-decoration-none">{{ $comment->post->user->name }}'s post</p></a>
                                </div>
                            </div>
                       </div>
                   @endforeach
               @else
                   <p class="text-muted text-center">No recent comments.</p>
               @endif
            </div>

            <div class="modal-footer border-0">
             <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-secondary ms-auto">Close</button>
           </div>
         </div>
       </div>
    </div>

    <div class="col">
        {{-- row 1 --}}
        <div class="row mb-3">
            <div class="col-auto">
            {{-- User Name --}}
                <h2 class="display-6 mb-0">{{ $user->name }}</h2>
            </div>
            <div class="col align-self-center">
                @if ($user->id == Auth::user()->id)
                    {{-- Edit Profile Button --}}
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-secondary">Edit Profile</a>
                @else
                    {{-- Follow Button --}}
                    @if ($user->isFollowing())
                        {{-- unfollow / following --}}
                        <form action="{{ route('follow.destroy', $user->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-secondary">Following</button>
                        </form>
                    @else
                        {{-- follow --}}
                        <form action="{{ route('follow.store', $user->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">Follow</button>
                        </form>
                    @endif
                @endif
            </div>
        </div>

        {{-- row 2 --}}
        <div class="row mb-3">
            {{-- posts number --}}
            <div class="col-auto">
                <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark">
                    <span class="fw-bold">{{ $user->posts->count() }}</span> {{ $user->posts->count()==1 ? 'post' : 'posts' }}
                    {{-- <conditoin> ? <true> : <false> --}}
                </a>
            </div>
            {{-- followers number--}}
            <div class="col-auto">
                <a href="{{ route('profile.followers', $user->id) }}" class="text-decoration-none text-dark">
                    <span class="fw-bold">{{ $user->followers->count() }}</span> {{ $user->followers->count()==1 ? 'follower' : 'followers' }}
                </a>
            </div>
            {{-- following number --}}
            <div class="col-auto">
                <a href="{{ route('profile.following', $user->id) }}" class="text-decoration-none text-dark">
                    <span class="fw-bold">{{ $user->follows->count() }}</span> following
                </a>
            </div>
        </div>

        {{-- description --}}
        <p class="fw-bold">{{ $user->introduction }}</p>

    </div>
</div>
