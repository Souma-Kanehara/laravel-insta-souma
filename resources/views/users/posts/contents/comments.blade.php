<div class="mt-3">


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
    {{-- Show all the commets here --}}
    @if ($post->comments->isNotEmpty())
        <hr>
        <ul class="list-group">
            @foreach ($post->comments->take(3) as $comment)
                <li class="list-group-item border-0 p-0 mb-2">
                    <a href="{{ route('profile.show', $comment->user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $comment->user->name }}</a>
                    &nbsp;
                    <p class="d-inline fw-light">{{ $comment->body }}</p>

                    <form action="{{ route('comment.destroy', $comment->id) }}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <span class="text-uppercase text-muted xsmall">{{ date('M d, Y', strtotime($comment->created_at)) }}</span>
                        {{-- If the AUTH (the user that is authenticated and logged-in) User is the owner of the comment, then show the DELETE button --}}
                        @if (Auth::user()->id === $comment->user->id)
                            <button type="submit" class="border-0 bg-transparent text-danger p-0 xsmall">Delete</button>
                        @endif
                    </form>
                        @if (Auth::user()->id === $post->user->id)
                            <button type="submit" class="border-0 bg-transparent text-danger p-0 xsmall" data-bs-toggle="modal" data-bs-target="#hide-comment-{{ $comment->id }}">Hide</button>
                        @endif
                        @include('users.posts.contents.modals.status')
                </li>
            @endforeach

                @if ($post->comments->count() > 3)
                    <li class="list-group-item border-0 px-0 pt-0">
                        <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none small">View All {{ $post->comments->count() }} comments</a>
                    </li>

                @endif

        </ul>
    @endif

</div>
