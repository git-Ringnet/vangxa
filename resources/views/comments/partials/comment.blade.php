<div class="comment pl-{{ $level ?? 0 }}">
    <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</p>

    <form action="{{ route('comments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="post_id" value="{{ $comment->post_id }}">
        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
        <div class="d-flex">
            <input type="text" name="content" placeholder="Trả lời..." class="form-control">
            <button type="submit" class="btn btn-primary">Reply</button>
        </div>
    </form>

    @if ($comment->children)
        @foreach ($comment->children as $child)
            @include('comments.partials.comment', ['comment' => $child, 'level' => ($level ?? 0) + 20])
        @endforeach
    @endif
</div>
