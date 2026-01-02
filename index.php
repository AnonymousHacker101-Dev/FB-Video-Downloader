<?php
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Facebook Video Downloader</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    body {
        font-family: 'Montserrat', sans-serif;
        background: radial-gradient(circle at top, #1a0000 0%, #000 55%);
        min-height: 100vh;
        color: #f5f5f5;
    }

    .main-card {
        background: #0b0b0b;
        border-radius: 22px;
        border: 2px solid #ff0000;
        box-shadow:
            0 0 25px rgba(255,0,0,0.35),
            inset 0 0 15px rgba(255,0,0,0.08);
    }

    .down-input {
        background: #050505;
        color: #fff;
        border: 1px solid #2a2a2a;
    }

    .down-input::placeholder {
        color: #777;
    }

    .down-input:focus {
        border-color: #ff0000 !important;
        box-shadow: 0 0 8px #ff0000 !important;
        background: #000;
    }

    .custom-btn {
        background: linear-gradient(90deg, #ff0000 0%, #7a0000 100%);
        font-weight: bold;
        color: #fff;
        border-radius: 50px;
        padding: 0.75rem 2.5rem;
        font-size: 1.12rem;
        transition: all 0.2s ease;
        box-shadow: 0 0 12px rgba(255,0,0,0.45);
    }

    .custom-btn:hover {
        filter: brightness(1.15);
        box-shadow: 0 0 22px rgba(255,0,0,0.75);
    }

    .download-link-btn {
        background: linear-gradient(90deg, #ff0000 0%, #ff3c00 100%);
        font-weight: 600;
        padding: 0.7em 2em;
        border-radius: 30px;
        color: #fff !important;
        display: inline-block;
        margin-top: 1rem;
        box-shadow: 0 0 10px rgba(255,0,0,0.5);
    }
</style>
</head>
<body class="flex flex-col min-h-screen justify-center items-center py-8">
    <div class="main-card w-full max-w-md relative p-6">
        <!-- Decorative Top Icon/Avatar -->
        <div class="w-20 h-20 rounded-full bg-gradient-to-b from-pink-300 to-pink-600 mx-auto -mt-16 shadow-lg flex items-center justify-center border-4 border-white">
            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 48 48">
                <rect x="13" y="18" width="22" height="15" rx="3" fill="#fff" stroke="#ff53aa"/>
                <path d="M24 23v5m0 0l2.5-2.5M24 28l-2.5-2.5" stroke="#ff53aa" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>
        <!-- Headline -->
        <h2 class="text-2xl font-bold text-center mt-5 mb-2 text-pink-500 tracking-tighter">Facebook Video Downloader</h2>
        <p class="text-gray-700 text-center text-[16px] mb-5">Paste any public Facebook video link below and get your download instantly, 100% free!</p>
        <!-- Form -->
        <form method="POST" class="flex flex-col gap-3">
            <input 
                type="url" 
                name="fburl" 
                required 
                placeholder="Paste Facebook video URL..." 
                class="down-input w-full py-3 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 text-black bg-[#fafaff] text-[16px]"
                value="<?= isset($_POST['fburl']) ? htmlspecialchars($_POST['fburl']) : '' ?>"
            />
            <button type="submit" class="custom-btn mt-1 mb-2 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 4v16m0 0l-6-6m6 6l6-6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Download
            </button>
        </form>
        <?php if ($error): ?>
            <div class="mt-3 mb-2 px-3 py-2 bg-pink-50 text-pink-800 text-center rounded"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($videoData): ?>
            <div class="bg-gray-50 rounded-xl p-4 mt-4 shadow-inner border border-pink-200 text-gray-800">
                <video controls poster="<?= htmlspecialchars($videoData['thumbnail']) ?>" class="w-full rounded-lg bg-black" preload="metadata">
                    <source src="<?= htmlspecialchars($videoData['url']) ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-gray-600 text-sm"><b>Quality:</b> <?= htmlspecialchars($videoData['quality']) ?></span>
                    <a href="download.php?url=<?= urlencode($videoData['url']) ?>" class="download-link-btn">⬇️ Save To Gallery</a>
                </div>
            </div>
            <div class="mt-2 flex justify-center"><a href="https://whatsapp.com/channel/0029VbBhNn1KgsNr47ZTsg1C" class="text-pink-600 underline font-medium" target="_blank">Join  —͟͞Shadow Cyber Ops Channel</a></div>
        <?php endif; ?>
    </div>
    <div class="mt-5 text-xs text-gray-500 text-center">&copy; <?= date('Y') ?> Salar King Made with ❤️ 
    By @SalarWC On TG</div>
</body>
</html>
