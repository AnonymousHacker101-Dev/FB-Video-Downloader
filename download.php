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
?>
