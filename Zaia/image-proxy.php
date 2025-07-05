<?php
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
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");

$image = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
curl_close($ch);

if ($httpCode !== 200 || !$image) {
  http_response_code(500);
  echo "Failed to load image.";
  exit;
}

header("Content-Type: $contentType");
echo $image;
