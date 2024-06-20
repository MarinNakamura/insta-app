@extends('layouts.app')

@section('title', $user->name)

@section('content')
    @include('user.profiles.header')

    <div class="row justify-content-center">
        <div class="col-4">
            {{-- show following --}}
            @if ($user->follows->isNotEmpty())
            <h3 class="h5 text-muted mb-3 text-center">Following</h3>

                @foreach ($user->follows as $follow)
                    <div class="row mb-3 align-items-center">
                        <div class="col-auto">
                            <a href="{{ route('profile.show', $follow->followed->id) }}">
                                {{-- icon --}}
                                @if ($follow->followed->avatar)
                                    <img src="{{ $follow->followed->avatar }}" alt="" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>

                        <div class="col ps-0 text-truncate">
                            {{-- following user name --}}
                            <a href="{{ route('profile.show', $follow->followed->id) }}" class="text-decoration-none fw-bold text-dark">{{ $follow->followed->name }}</a>
                        </div>

                        <div class="col auto">
                        {{-- button --}}
                            @if ($follow->followed->id != Auth::user()->id)

                                @if ($follow->followed->isFollowing())
                                    {{-- following / unfollow --}}
                                    <form action="{{ route('follow.destroy', $follow->followed->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn p-0 text-outline-secondary">Following</button>
                                    </form>

                                @else
                                    {{-- follow --}}
                                    <form action="{{ route('follow.store', $follow->followed->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn p-0 text-primary">Follow</button>
                                    </form>
                                @endif

                            @endif
                        </div>
                    </div>
                @endforeach

            @else
                <p class="text-center text-muted h5">Not following anyone yet.</p>
            @endif
        </div>
    </div>
@endsection
