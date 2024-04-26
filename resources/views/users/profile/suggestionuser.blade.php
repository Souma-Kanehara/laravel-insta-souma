@extends('layouts.app')

@section('title', 'Suggestion User')

@section('content')
    @foreach ($suggested_users as $user)
        <div class="row my-5 shadow">
            <div class="col-4 my-1">
                @if ($user->avatar)
                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="img-thumbnail rounded-circle d-block mx-auto avatar-md">
                @else
                    <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-lg"></i>
                @endif
            </div>
            <div class="col-8">
                <div class="row mb-3">
                    <div class="col-auto">
                        <h2 class="display-6 mb-0">{{ $user->name }}</h2>
                    </div>
                    <div class="col-auto p-2">
                        @if ($user->isFollowed())
                            <form action="{{ route('follow.destroy', $user->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-secondary btn-sm fw-bold">Following</button>
                            </form>
                        @else
                            <form action="{{ route('follow.store', $user->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm fw-bold">Follow</button>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-auto">
                        <a href="" class="text-decoration-none text-dark">
                            <strong>{{ $user->posts()->count() }}</strong> {{ $user->posts()->count() == 1 ? 'Post' : 'Posts' }}
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('profile.followers',$user->id) }}" class="text-decoration-none text-dark">
                            <strong>{{ $user->followers->count() }}</strong> {{ $user->followers->count() == 1 ? 'follower' : 'followers' }}
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('profile.following',$user->id) }}" class="text-decoration-none text-dark">
                            <strong>{{ $user->following->count() }}</strong> Following
                        </a>
                    </div>
                </div>
                <p class="fw-bold">{{ $user->introduction }}</p>
            </div>
        </div>
    @endforeach
    <div class="d-flex justify-content-center">
        {{ $suggested_users->links() }}
    </div>
@endsection
