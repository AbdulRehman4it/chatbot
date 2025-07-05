<?php
// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");

// Get and decode the URL parameter
$url = isset($_GET['url']) ? urldecode($_GET['url']) : null;

if (!$url) {
    http_response_code(400);
    echo "Missing url parameter";
    exit;
}

// Validate URL schema (http or https)
if (!preg_match('/^https?:\/\//i', $url)) {
    http_response_code(400);
    echo "Invalid URL schema";
    exit;
}

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_TIMEOUT, 20);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] ?? 'Mozilla/5.0');

$image = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr = curl_error($ch);
curl_close($ch);

if ($image === false || $httpCode !== 200) {
    http_response_code(502);
    echo "Failed to fetch image. HTTP code: $httpCode, cURL error: $curlErr";
    exit;
}

// Detect content type of the fetched image
$finfo = new finfo(FILEINFO_MIME_TYPE);
$contentType = $finfo->buffer($image);

header("Content-Type: $contentType");

// Output the image content
echo $image;

?>