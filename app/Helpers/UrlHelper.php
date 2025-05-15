<?php

namespace App\Helpers;

class UrlHelper
{
    /**
     * Tạo URL chia sẻ có tham số UTM
     *
     * @param string $url URL gốc cần chia sẻ
     * @param string $platform Nền tảng chia sẻ (facebook, instagram, twitter, tiktok...)
     * @param string|null $campaign Tên chiến dịch (nếu có)
     * @return string URL có tham số UTM
     */
    public static function addUtmParams($url, $platform, $campaign = null)
    {
        $params = [
            'utm_source' => $platform,
            'utm_medium' => 'social',
            'utm_campaign' => $campaign ?: 'vendor_profile'
        ];
        
        $separator = (parse_url($url, PHP_URL_QUERY) ? '&' : '?');
        
        return $url . $separator . http_build_query($params);
    }
    
    /**
     * Tạo các URL chia sẻ cho các nền tảng phổ biến
     *
     * @param string $url URL gốc cần chia sẻ
     * @param string $title Tiêu đề nội dung (nếu cần)
     * @return array Danh sách URL chia sẻ cho các nền tảng
     */
    public static function getSocialShareUrls($url, $title = '')
    {
        $encodedUrl = urlencode($url);
        $encodedTitle = urlencode($title);
        
        // Thêm UTM params cho mỗi nền tảng
        $urlWithUtmFacebook = self::addUtmParams($url, 'facebook');
        $urlWithUtmTwitter = self::addUtmParams($url, 'twitter');
        $urlWithUtmLinkedIn = self::addUtmParams($url, 'linkedin');
        $urlWithUtmPinterest = self::addUtmParams($url, 'pinterest');
        $urlWithUtmTelegram = self::addUtmParams($url, 'telegram');
        $urlWithUtmReddit = self::addUtmParams($url, 'reddit');
        $urlWithUtmTiktok = self::addUtmParams($url, 'tiktok');
        
        return [
            'facebook' => "https://www.facebook.com/sharer/sharer.php?u=" . urlencode($urlWithUtmFacebook),
            'twitter' => "https://twitter.com/intent/tweet?url=" . urlencode($urlWithUtmTwitter) . "&text=" . $encodedTitle,
            'linkedin' => "https://www.linkedin.com/sharing/share-offsite/?url=" . urlencode($urlWithUtmLinkedIn),
            'pinterest' => "https://pinterest.com/pin/create/button/?url=" . urlencode($urlWithUtmPinterest) . "&description=" . $encodedTitle,
            'telegram' => "https://t.me/share/url?url=" . urlencode($urlWithUtmTelegram) . "&text=" . $encodedTitle,
            'reddit' => "https://www.reddit.com/submit?url=" . urlencode($urlWithUtmReddit) . "&title=" . $encodedTitle,
            'tiktok' => $urlWithUtmTiktok, // Không có API chia sẻ trực tiếp, sẽ xử lý bằng modal như Instagram
            'copy' => $url
        ];
    }
} 