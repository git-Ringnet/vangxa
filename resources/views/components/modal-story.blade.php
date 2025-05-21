<div class="story-modal" id="storyModal-{{ $post->id }}">
    <div class="story-modal-content">
        <!-- Header với thông tin vendor và nút đóng -->
        <div class="story-modal-header">
            <div class="vendor-info d-flex align-items-center">
                <img src="{{ $post->user->avatar ?? asset('image/default/default-avatar.jpg') }}" alt="{{ $post->user->name }}" class="rounded-circle me-3" width="50" height="50">
                <div>
                    <h4 class="mb-0">{{ $post->user->name }}</h4>
                    <p class="text-muted small mb-0">
                        Vendor
                    </p>
                </div>
            </div>
            <button type="button" class="btn-close" onclick="closeStoryModal('{{ $post->id }}')" aria-label="Close"></button>
        </div>

        <!-- Nội dung câu chuyện -->
        <div class="story-modal-body">
            @if($post->user->stories->count() > 0)
                @foreach($post->user->stories as $story)
                    <div class="story-item mb-4">
                        @if($story->image_path)
                            <div class="story-image mb-3">
                                <img src="{{ asset('storage/' . $story->image_path) }}" alt="Story Image" class="img-fluid rounded">
                            </div>
                        @endif
                        
                        <div class="story-content">
                            @if($story->title)
                                <h3 class="story-title mb-2">{{ $story->title }}</h3>
                            @endif
                            <div class="story-text">
                                {!! nl2br(e($story->content)) !!}
                            </div>
                            <div class="story-date text-muted mt-2">
                                <small><i class="far fa-calendar-alt me-1"></i>{{ $story->created_at->format('d/m/Y') }}</small>
                            </div>
                        </div>
                    </div>
                    @if(!$loop->last)
                        <hr class="story-divider my-4">
                    @endif
                @endforeach
            @else
                <div class="text-center py-5">
                    <i class="fas fa-book fa-3x mb-3 text-muted"></i>
                    <h5>Chưa có câu chuyện nào</h5>
                    <p class="text-muted">Vendor này chưa chia sẻ câu chuyện nào.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.story-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    display: none;
    z-index: 9999;
    overflow-y: auto;
    padding: 30px 0;
}

.story-modal-content {
    max-width: 700px;
    margin: 0 auto;
    background-color: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    max-height: 85vh;
    display: flex;
    flex-direction: column;
}

.story-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px;
    border-bottom: 1px solid #eee;
    flex-shrink: 0;
}

.story-modal-body {
    padding: 25px;
    overflow-y: auto;
    flex-grow: 1;
}

.story-image img {
    width: 100%;
    max-height: 400px;
    object-fit: cover;
}

.story-title {
    font-weight: 600;
    color: #333;
    font-size: 1.5rem;
}

.story-text {
    font-size: 1.05rem;
    line-height: 1.7;
    color: #444;
    white-space: pre-line;
    overflow-wrap: break-word;
    word-wrap: break-word;
}

.story-divider {
    border-color: #eee;
}

/* Custom scrollbar for the modal */
.story-modal-body::-webkit-scrollbar {
    width: 8px;
}

.story-modal-body::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.story-modal-body::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.story-modal-body::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
