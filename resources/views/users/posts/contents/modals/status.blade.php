{{-- Hide Comment --}}
<div class="modal fade" id="hide-comment-{{ $comment->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            {{-- <div class="modal-header boder-danger">
                <h3 class="h5 modal-title text-danger">
                    <i class="fa-solid fa-user-slash"></i> Deactivate User
                </h3>
            </div> --}}
            <div class="modal-body text-center">
                Hide this comment and it will be hidden permanently <br>
                Are you sure you want to hide this comment <span class="fw-bold">"{{ $comment->body }}" </span> ?
            </div>
            <div class="modal-footer border-0">
                <form action="{{ route('comment.hide',$comment->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Hide</button>
                </form>
            </div>
        </div>
    </div>
</div>
