<?php
if (isset($_GET['url'])) {
    $videoUrl = urldecode($_GET['url']);
    $filename = "facebook_video_" . date('YmdHis') . ".mp4";

    // Set headers to force download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');

    // Flush and read file
    ob_clean();
    flush();

    // Pass remote file to browser (this works only if allow_url_fopen = On)
    readfile($videoUrl);
    exit;
} else {
    echo "❌ অবৈধ ডাউনলোড URL।";
}
$videoData = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fburl'])) {
    $url = trim($_POST['fburl']);
    $api = 'https://facebook-downloader.apis-bj-devs.workers.dev/?url=' . urlencode($url);

    $response = @file_get_contents($api);
    if ($response !== false) {
        $json = json_decode($response, true);
        if ($json !== null && isset($json['status']) && $json['status'] === true && isset($json['data'])) {
            $videoData = $json['data'];
        } else {
            $error = "⚠️ Video download failed. Please provide a valid URL or there might be an issue with the API.";
        }
    } else {
        $error = "❌ Failed to fetch data from the API. Please check your network connection or the API URL.";
    }
}
?>
