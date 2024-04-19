@extends('layouts.app')

@section('title', 'Show Post')

@section('content')
    <div class="row border shadow">
        <div class="col p-0 border-end">
            {{-- show the image here --}}
            <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="w-100">
        </div>
        <div class="col-4 px-0 bg-white">
            <div class="card border-0">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <a href="{{ route('profile.show', $post->user->id) }}">
                                @if ($post->user->avatar)
                                    <img src="{{ $post->user->avatar }}" alt="{{ $post->user->avatar }}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>
                        <div class="col ps-0">
                            <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-secondary">{{ $post->user->name }}</a>
                        </div>
                        <div class="col-auto">
                            {{-- I you are the owner of the post, the you can edit and delete the post --}}
                            @if (Auth::user()->id === $post->user->id)
                                <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>

                                <div class="dropdown-menu">
                                    <a href="{{ route('post.edit', $post->id) }}" class="dropdown-item">
                                        <i class="fa-regular fa-pen-to-square"></i> Edit
                                    </a>
                                    <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-post-{{$post->id}}">
                                        <i class="fa-regular fa-trash-can"></i> Delete
                                    </button>
                                </div>
                                {{-- Include/insert a modal here --}}
                                @include('users.posts.contents.modals.delete')
                            @else
                                @if ($post->user->isFollowed())
                                    <form action="{{ route('follow.destroy', $post->user->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-secondary btn-sm fw-bold">Following</button>
                                    </form>
                                @else
                                    <form action="{{ route('follow.store', $post->user->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm fw-bold">Follow</button>
                                    </form>
                                @endif
                                {{-- If you are not the owner of the post, then you will the follow/unfollow button only --}}
                                {{-- We'll discuss this later on  --}}
                                {{-- Show a follow/unfollow button --}}
                                {{-- <form action="{{ route('follow.store', $post->user->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="border-0 bg-transparent p-0 text-primary">Follow</button>
                                </form> --}}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body w-100">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            @if ($post->isLiked())
                                <form action="{{ route('like.destroy', $post->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn shadow-none sm p-0"><i class="fa-solid fa-heart text-danger"></i></button>
                                </form>
                            @else
                                <form action="{{ route('like.store', $post->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn shadow-none sm p-0"><i class="fa-regular fa-heart"></i></button>
                                </form>
                            @endif

                        </div>
                        <div class="col-auto px-0">
                            <span>{{ $post->likes->count() }}</span>
                        </div>
                        <div class="col text-end">
                            @forelse ($post->categoryPost as $category_post)
                                <span class="badge bg-secondary bg-opacity-50">{{ $category_post->category->name }}</span>
                            @empty
                                <div class="badge bg-dark text-wrap">Uncategorized</div>
                            @endforelse
                            {{-- @foreach ($post->categoryPost as $category_post)
                                <div class="badge bg-secondary bg-opacity-50">{{ $category_post->category->name }}</div>
                            @endforeach --}}
                        </div>
                    </div>
                    {{-- Owner of the post + description of the post --}}
                    <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $post->user->name }}</a>
                    {{-- &nbsp; is use to add avery thin space --}}
                    &nbsp;
                    <p class="d-inline fw-light">{{ $post->description }}</p>
                    <p class="text-uppercase text-muted xsmall">{{date('M d, Y', strtotime($post->created_at))}}</p>
                    <p class="text-danger small">Posted in {{ $post->created_at->diffForHumans() }}</p>

                    {{-- Comments section --}}
                    <div class="mt-4" style="height: 160px; overflow-y: scroll">
                        {{-- style create the scroll bar at comment --}}

                        <form action="{{ route('comment.store', $post->id) }}" method="post">
                            @csrf
                            <div class="input-group">
                                <textarea name="comment_body{{ $post->id }}" id="" rows="1" class="form-control form-control-sm" placeholder="Add a comment...">{{ old('comment_body' . $post->id) }}</textarea>
                                <button type="submit" class="btn btn-outline-secondary btn-sm">Post</button>
                            </div>
                            {{-- Error message area --}}
                            @error('comment_body' . $post->id)
                                <p class="text-danger samll">{{ $message }}</p>
                            @enderror
                        </form>

                        {{-- Show all comments --}}
                        @if ($post->comments->isNotEmpty())
                            <ul class="list-group mt-2">
                                @foreach ($post->comments as $comment)
                                    <li class="list-group-item border-0 p-0 mb-2">
                                        <a href="{{ route('profile.show', $comment->user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $comment->user->name }}</a>
                                        &nbsp;
                                        <p class="d-inline fw-light">{{ $comment->body }}</p>

                                        <form action="{{ route('comment.destroy', $comment->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <span class="text-uppercase text-muted xsmall">{{ date('M d, Y', strtotime($comment->created_at)) }}</span>

                                            {{-- If the AUTH (the user that is authenticated and logged-in) User is the owner of the comment, then show the DELETE button --}}
                                            @if (Auth::user()->id === $comment->user->id)
                                                <button type="submit" class="border-0 bg-transparent text-danger p-0 xsmall">Delete</button>
                                            @endif

                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
