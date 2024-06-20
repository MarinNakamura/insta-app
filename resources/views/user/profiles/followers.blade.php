@extends('layouts.app')

@section('title', $user->name)

@section('content')
    @include('user.profiles.header')

    <div class="row justify-content-center">
        <div class="col-4">
            {{-- Show followers --}}
            @if ($user->followers->isNotEmpty())
            <h3 class="h5 text-muted mb-3 text-center">Followers</h3>

            @foreach ($user->followers as $follow)
                <div class="row mb-3 align-items-center">
                    <div class="col-auto">
                        <a href="{{ route('profile.show', $follow->follower->id) }}">
                            @if ($follow->follower->avatar)
                                <img src="{{ $follow->follower->avatar }}" alt="" class="rounded-circle avatar-sm">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                            @endif
                        </a>
                    </div>
                    <div class="col ps-0 text-truncate"> {{-- if the username is too long, it will be cut off --}}
                        <a href="{{ route('profile.show', $follow->follower->id) }}" class="text-decoration-none fw-bold text-dark">{{ $follow->follower->name }}</a>
                    </div>
                    <div class="col-auto">
                        {{-- button --}}
                        @if ($follow->follower->id != Auth::user()->id)

                            @if ($follow->follower->isFollowing())
                                {{-- following / unfollow  --}}
                                <form action="{{ route('follow.destroy', $follow->follower->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn p-0 text-outline-secondary">Following</button>
                                </form>
                            @else
                                {{-- follow --}}
                                <form action="{{ route('follow.store', $follow->follower->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn p-0 text-primary">Follow</button>
                                </form>
                            @endif

                        @endif
                    </div>
                </div>
            @endforeach

            @else
                <p class="text-center text-muted h5">No followers yet.</p>
            @endif
        </div>
    </div>
@endsection
