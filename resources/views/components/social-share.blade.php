@php
    // Load UrlHelper
    use App\Helpers\UrlHelper;
    
    // Tạo URL cho các nền tảng chia sẻ
    $shareUrls = UrlHelper::getSocialShareUrls($url, $title ?? '');
    $tiktokShareUrl = UrlHelper::addUtmParams($url, 'tiktok');
@endphp

<div class="social-share-buttons">
    <span class="mr-2">Chia sẻ:</span>
    
    <!-- Facebook -->
    <a href="{{ $shareUrls['facebook'] }}" target="_blank" class="btn btn-sm btn-social btn-facebook mb-1 mr-1" 
       data-toggle="tooltip" title="Chia sẻ qua Facebook">
        <i class="fab fa-facebook-f"></i>
    </a>
    
    <!-- Twitter/X -->
    <a href="{{ $shareUrls['twitter'] }}" target="_blank" class="btn btn-sm btn-social btn-twitter mb-1 mr-1" 
       data-toggle="tooltip" title="Chia sẻ qua Twitter/X">
        <i class="fab fa-twitter"></i>
    </a>
    
    <!-- LinkedIn -->
    <a href="{{ $shareUrls['linkedin'] }}" target="_blank" class="btn btn-sm btn-social btn-linkedin mb-1 mr-1" 
       data-toggle="tooltip" title="Chia sẻ qua LinkedIn">
        <i class="fab fa-linkedin-in"></i>
    </a>
    
    <!-- Web Share API -->
    <button type="button" class="btn btn-sm btn-social btn-more mb-1 mr-1 web-share-btn" 
            data-toggle="tooltip" title="Chia sẻ qua ứng dụng khác"
            data-url="{{ $url }}" data-title="{{ $title ?? '' }}" data-text="{{ $description ?? $title ?? '' }}">
        <i class="fas fa-share-alt"></i>
    </button>
    
    <!-- Copy Link -->
    <button type="button" class="btn btn-sm btn-light mb-1 copy-link" 
            data-clipboard-text="{{ UrlHelper::addUtmParams($url, 'direct_copy') }}"
            data-toggle="tooltip" title="Sao chép liên kết">
        <i class="far fa-copy"></i>
    </button>
</div>

<!-- Fallback Modal for Web Share API -->
<div class="modal fade" id="fallbackShareModal" tabindex="-1" aria-labelledby="fallbackShareModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fallbackShareModalLabel">Chia sẻ qua các nền tảng khác</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row row-cols-3 g-3">
                    <!-- Pinterest -->
                    <div class="col">
                        <a href="{{ $shareUrls['pinterest'] }}" target="_blank" class="d-block text-center text-decoration-none p-2 border rounded">
                            <i class="fab fa-pinterest fa-2x text-danger mb-2"></i>
                            <p class="m-0 small">Pinterest</p>
                        </a>
                    </div>
                    
                    <!-- Telegram -->
                    <div class="col">
                        <a href="{{ $shareUrls['telegram'] }}" target="_blank" class="d-block text-center text-decoration-none p-2 border rounded">
                            <i class="fab fa-telegram-plane fa-2x text-info mb-2"></i>
                            <p class="m-0 small">Telegram</p>
                        </a>
                    </div>
                    
                    <!-- Reddit -->
                    <div class="col">
                        <a href="{{ $shareUrls['reddit'] }}" target="_blank" class="d-block text-center text-decoration-none p-2 border rounded">
                            <i class="fab fa-reddit-alien fa-2x text-danger mb-2"></i>
                            <p class="m-0 small">Reddit</p>
                        </a>
                    </div>
                    
                    <!-- Email -->
                    <div class="col">
                        <a href="mailto:?subject={{ urlencode($title ?? '') }}&body={{ urlencode(($description ?? '') . "\n\n" . $url) }}" class="d-block text-center text-decoration-none p-2 border rounded">
                            <i class="fas fa-envelope fa-2x text-secondary mb-2"></i>
                            <p class="m-0 small">Email</p>
                        </a>
                    </div>
                    
                    <!-- WhatsApp -->
                    <div class="col">
                        <a href="https://api.whatsapp.com/send?text={{ urlencode(($title ?? '') . "\n\n" . $url) }}" target="_blank" class="d-block text-center text-decoration-none p-2 border rounded">
                            <i class="fab fa-whatsapp fa-2x text-success mb-2"></i>
                            <p class="m-0 small">WhatsApp</p>
                        </a>
                    </div>
                    
                    <!-- SMS/Message -->
                    <div class="col">
                        <a href="{{ $shareUrls['sms'] }}" class="d-block text-center text-decoration-none p-2 border rounded">
                            <i class="fas fa-sms fa-2x text-primary mb-2"></i>
                            <p class="m-0 small">SMS/Message</p>
                        </a>
                    </div>
                    
                    <!-- TikTok (Requires manual sharing) -->
                    <div class="col tiktok-share" data-share-url="{{ $tiktokShareUrl }}">
                        <div class="d-block text-center text-decoration-none p-2 border rounded" style="cursor:pointer">
                            <i class="fab fa-tiktok fa-2x mb-2"></i>
                            <p class="m-0 small">TikTok</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TikTok Share Modal -->
<div class="modal fade" id="tiktokShareModal" tabindex="-1" aria-labelledby="tiktokShareModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tiktokShareModalLabel">Chia sẻ qua TikTok</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p>TikTok không hỗ trợ chia sẻ trực tiếp từ trình duyệt. Bạn có thể:</p>
                <ol class="text-start">
                    <li>Sao chép liên kết này</li>
                    <div class="input-group mb-3">
                        <input type="text" id="tiktokShareUrl" class="form-control" value="{{ $tiktokShareUrl }}" readonly>
                        <button class="btn btn-outline-primary copy-tiktok-link" type="button">
                            <i class="far fa-copy"></i> Sao chép
                        </button>
                    </div>
                    <li>Mở ứng dụng TikTok trên thiết bị của bạn</li>
                    <li>Tạo video mới và dán liên kết vào mô tả</li>
                </ol>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-social {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-facebook {
        background-color: #3b5998;
        color: white;
    }
    .btn-twitter {
        background-color: #1DA1F2;
        color: white;
    }
    .btn-linkedin {
        background-color: #0077b5;
        color: white;
    }
    .btn-more {
        background-color: #6c757d;
        color: white;
    }
    .btn-social:hover {
        opacity: 0.9;
        color: white;
    }
</style>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize clipboard for normal copy button
        var clipboard = new ClipboardJS('.copy-link');
        
        clipboard.on('success', function(e) {
            // Hiển thị thông báo đã sao chép
            let button = e.trigger;
            let originalTitle = button.getAttribute('data-original-title');
            
            button.setAttribute('data-original-title', 'Đã sao chép!');
            $(button).tooltip('show');
            
            setTimeout(function() {
                button.setAttribute('data-original-title', originalTitle);
            }, 1500);
            
            e.clearSelection();
        });
        
        // Web Share API handler
        $('.web-share-btn').on('click', function() {
            const shareData = {
                title: $(this).data('title'),
                text: $(this).data('text'),
                url: $(this).data('url')
            };
            
            // Kiểm tra xem trình duyệt có hỗ trợ Web Share API không
            if (navigator.share && navigator.canShare && navigator.canShare(shareData)) {
                navigator.share(shareData)
                    .then(() => console.log('Chia sẻ thành công'))
                    .catch((error) => {
                        console.log('Lỗi khi chia sẻ:', error);
                        $('#fallbackShareModal').modal('show');
                    });
            } else {
                // Fallback for browsers that don't support Web Share API
                console.log('Web Share API không được hỗ trợ');
                $('#fallbackShareModal').modal('show');
            }
        });
        
        // TikTok share button click handler
        $('.tiktok-share').on('click', function(e) {
            e.preventDefault();
            $('#fallbackShareModal').modal('hide');
            $('#tiktokShareModal').modal('show');
        });
        
        // Initialize clipboard for TikTok URL
        var tiktokClipboard = new ClipboardJS('.copy-tiktok-link', {
            target: function() {
                return document.getElementById('tiktokShareUrl');
            }
        });
        
        tiktokClipboard.on('success', function(e) {
            let button = e.trigger;
            let originalHtml = button.innerHTML;
            
            button.innerHTML = '<i class="fas fa-check"></i> Đã sao chép';
            
            setTimeout(function() {
                button.innerHTML = originalHtml;
            }, 1500);
            
            e.clearSelection();
        });
        
        // Kích hoạt tooltip
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush 