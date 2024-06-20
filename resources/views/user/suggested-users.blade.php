@extends('layouts.app')

@section('title', 'Suggested Users')

@section('content')
        <div class="row justify-content-center mb-3">
            <div class="col-4">
                <form action="{{ route('user.suggested') }}" method="get">
                    <input type="text" name="search" placeholder="search names..." class="form-control form-control-sm" value="{{ $search }}">
                </form>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-4">
                <h4 class="h5 fw-bold mb-3">Suggested</h4>
                @foreach ($suggested_users as $user)
                    <div class="row">
                        <div class="col-auto">
                            <a href="{{ route('profile.show', $user->id) }}">
                                @if ($user->avatar)
                                    <img src="{{ $user->avatar }}" alt="" class="rounded-circle avatar-md">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                                @endif
                            </a>
                        </div>

                        <div class="col">
                            {{-- User name --}}
                            <div class="row">
                                <div class="col ps-0 text-truncate">
                                    <a href="{{ route('profile.show', $user->id) }}"
                                        class="text-decoration-none fw-bold text-dark">{{ $user->name }}</a>
                                </div>
                            </div>

                            {{-- email address --}}
                            <div class="row mb-0">
                                <div class="col ps-0 text-truncate mb-0">
                                    <p class="text-muted mb-0">{{ $user->email }}</p>
                                </div>
                            </div>

                            {{-- Follower info --}}
                            <div class="row mb-0">
                                <div class="col ps-0">
                                    {{-- @if ($user->followed_id != Auth::user()->id) --}}
                                    @if ($user->authorIsFollowed())
                                        <p class="text-muted">Follows you</p>
                                    @else
                                        @if ($user->followers->count() != 0)
                                            <p class="text muted">
                                                {{ $user->followers->count() }} {{ $user->followers->count()==1 ? 'follower' : 'followers' }}
                                            </p>
                                        @else
                                            <p class="text-muted">No followers yet</p>
                                        @endif
                                    {{-- @endif --}}
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- button --}}
                        <div class="col-auto ps-0">
                            <form action="{{ route('follow.store', $user->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn p-0 text-primary">Follow</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endsection
