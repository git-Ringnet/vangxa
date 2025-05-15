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
    
    <!-- Twitter -->
    <a href="{{ $shareUrls['twitter'] }}" target="_blank" class="btn btn-sm btn-social btn-twitter mb-1 mr-1" 
       data-toggle="tooltip" title="Chia sẻ qua Twitter">
        <i class="fab fa-twitter"></i>
    </a>
    
    <!-- LinkedIn -->
    <a href="{{ $shareUrls['linkedin'] }}" target="_blank" class="btn btn-sm btn-social btn-linkedin mb-1 mr-1" 
       data-toggle="tooltip" title="Chia sẻ qua LinkedIn">
        <i class="fab fa-linkedin-in"></i>
    </a>
    
    <!-- Pinterest -->
    <a href="{{ $shareUrls['pinterest'] }}" target="_blank" class="btn btn-sm btn-social btn-pinterest mb-1 mr-1" 
       data-toggle="tooltip" title="Chia sẻ qua Pinterest">
        <i class="fab fa-pinterest-p"></i>
    </a>
    
    <!-- Reddit -->
    <a href="{{ $shareUrls['reddit'] }}" target="_blank" class="btn btn-sm btn-social btn-reddit mb-1 mr-1" 
       data-toggle="tooltip" title="Chia sẻ qua Reddit">
        <i class="fab fa-reddit-alien"></i>
    </a>
    
    <!-- Telegram -->
    <a href="{{ $shareUrls['telegram'] }}" target="_blank" class="btn btn-sm btn-social btn-telegram mb-1 mr-1" 
       data-toggle="tooltip" title="Chia sẻ qua Telegram">
        <i class="fab fa-telegram-plane"></i>
    </a>
    
    <!-- TikTok -->
    <a href="javascript:void(0);" class="btn btn-sm btn-social btn-tiktok mb-1 mr-1 tiktok-share" 
       data-toggle="tooltip" title="Chia sẻ qua TikTok"
       data-share-url="{{ $tiktokShareUrl }}" data-share-title="{{ $title ?? '' }}">
        <i class="fab fa-tiktok"></i>
    </a>
    
    <!-- Copy Link -->
    <button type="button" class="btn btn-sm btn-light mb-1 copy-link" 
            data-clipboard-text="{{ UrlHelper::addUtmParams($url, 'direct_copy') }}"
            data-toggle="tooltip" title="Sao chép liên kết">
        <i class="far fa-copy"></i>
    </button>
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
    .btn-pinterest {
        background-color: #E60023;
        color: white;
    }
    .btn-reddit {
        background-color: #FF5700;
        color: white;
    }
    .btn-telegram {
        background-color: #0088cc;
        color: white;
    }
    .btn-tiktok {
        background-color: #000000;
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
        
        // TikTok share button click handler
        $('.tiktok-share').on('click', function(e) {
            e.preventDefault();
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