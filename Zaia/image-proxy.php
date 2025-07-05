<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_GET['url'])) {
  http_response_code(400);
  echo "Missing image URL.";
  exit;
}

$url = $_GET['url'];

if (!filter_var($url, FILTER_VALIDATE_URL)) {
  http_response_code(400);
  echo "Invalid URL.";
  exit;
}

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64)");
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Referer: https://kinkybunny.app"
]);

$image = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
$error = curl_error($ch);
curl_close($ch);

if ($httpCode !== 200 || !$image) {
  http_response_code(500);
  echo "Failed to load image.\n";
  echo "URL: $url\n";
  echo "HTTP Code: $httpCode\n";
  echo "cURL Error: $error\n";
  exit;
}

header("Content-Type: $contentType");
echo $image;
?>