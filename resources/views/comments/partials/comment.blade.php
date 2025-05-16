<div class="comment mb-2">
    <div class="d-flex">
        <div class="flex-grow-1">
            <div class="rounded p-2">
                <strong>{{ $comment->user->name }}</strong>
                <p class="mb-0">{{ $comment->content }}</p>
            </div>
            <div class="d-flex align-items-center mt-1">
                <small class="text-white-blur me-2">{{ $comment->created_at->diffForHumans() }}</small>
                @if (Auth::check())
                    <button class="btn btn-link text-decoration-none p-0 reply-toggle"
                        data-comment-id="{{ $comment->id }}">
                        <i class="far fa-comment me-1"></i> Phản hồi
                    </button>
                @endif
            </div>

            <!-- Reply Form -->
            <div class="reply-form mt-2" id="reply-form-{{ $comment->id }}" style="display: none;">
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $comment->post_id }}">
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <div class="input-group">
                        <input type="text" name="content" class="form-control" placeholder="Viết phản hồi..."
                            autocomplete="off">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- ĐỆ QUY COMMENT CON -->
            @if ($comment->children->isNotEmpty())
                <div class="children-comments mt-2">
                    @foreach ($comment->children as $child)
                        @include('comments.partials.comment', ['comment' => $child])
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle reply form
            document.querySelectorAll('.reply-toggle').forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.dataset.commentId;
                    const replyForm = document.getElementById(`reply-form-${commentId}`);
                    replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
                });
            });
        });
    </script>
@endpush

<style>
    .children-comments {
        margin-left: 20px;
        position: relative;
        padding-left: 15px;
    }
</style>
