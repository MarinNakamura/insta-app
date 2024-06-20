@extends('layouts.app')

@section('title', 'Admin: Users')

@section('content')
    <div class="row">
        <div class="col-10"></div>
        <div class="mb-3 col-2">
            @auth
                <form action="{{ route('admin.users') }}" method="get">
                    <input type="text" name="search" placeholder="search user name..." class="form-control" value="{{ $search }}">
                </form>
            @endauth
        </div>
    </div>

    <table class="table border table-hover align-middle bg-white text-secondary">
        <thead class="table-success text-secondary text-uppercase small">
            <tr>
                <th></th>
                <th>Name</th>
                <th>Email</th>
                <th>Create At</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($all_users as $user)
                <tr>
                    {{-- Icon --}}
                    <td>
                        @if ($user->avatar)
                            <img src="{{ $user->avatar }}" alt="" class="rounded-circle avatar-md d-block mx-auto">
                        @else
                            <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-md"></i>
                        @endif
                    </td>
                    {{-- Name --}}
                    <td>
                        <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none fw-bold text-dark">
                            {{ $user->name }}
                        </a>
                    </td>
                    {{-- Email --}}
                    <td>{{ $user->email }}</td>
                    {{-- Created at --}}
                    <td>{{ $user->created_at }}</td>
                    {{-- status --}}
                    <td>
                        @if ($user->trashed())
                            <i class="fa-regular fa-circle"></i> Inactive
                        @else
                            <i class="fa-solid fa-circle text-success"></i> Active
                        @endif
                    </td>
                    {{-- menu --}}
                    <td>
                        @if ($user->id != Auth::user()->id)
                            <div class="dropdown">
                                <button class="btn btn-sm" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>

                                <div class="dropdown-menu">
                                    @if ($user->trashed())
                                        {{-- activate --}}
                                        <button class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#activate-user{{ $user->id }}">
                                            <i class="fa-solid fa-user-check"></i> Activate {{ $user->name }}
                                        </button>
                                    @else
                                        {{-- deactivate --}}
                                        <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                            data-bs-target="#deactivate-user{{ $user->id }}">
                                            <i class="fa-solid fa-user-slash"></i> Deactivate {{ $user->name }}
                                        </button>
                                    @endif
                                </div>


                            </div>
                            @include('admin.users.actions')
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="6">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $all_users->links() }} {{-- shows the pages --}}
@endsection


{{-- Soft delete - archiving --}}
{{-- 1. change the table itself through migration --}}
{{-- 2. chagnge the model user --}}
