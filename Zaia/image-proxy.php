<?php
header("Access-Control-Allow-Origin: *");

if (!isset($_GET['url'])) {
    http_response_code(400);
    echo "Missing 'url' parameter.";
    exit;
}

$url = $_GET['url'];

if (!filter_var($url, FILTER_VALIDATE_URL) || !in_array(parse_url($url, PHP_URL_SCHEME), ['http', 'https'])) {
    http_response_code(400);
    echo "Invalid URL.";
    exit;
}

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);

if ($response === false) {
    $error = curl_error($ch);
    file_put_contents("failed-urls.log", date('Y-m-d H:i:s') . " - CURL FAILED: $url | Error: $error" . PHP_EOL, FILE_APPEND);
    http_response_code(502);
    echo "Curl error: " . curl_error($ch);
    curl_close($ch);
    exit;
}

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$headers = substr($response, 0, $headerSize);
$image = substr($response, $headerSize);  // <- Here we assign image content to $image

curl_close($ch);

if ($httpCode !== 200) {
    http_response_code($httpCode);
    echo "Error fetching image. HTTP status code: $httpCode";
    exit;
}

foreach (explode("\r\n", $headers) as $headerLine) {
    if (stripos($headerLine, 'Content-Type:') === 0) {
        header($headerLine);
    }
    if (stripos($headerLine, 'Cache-Control:') === 0) {
        header($headerLine);
    }
    if (stripos($headerLine, 'Expires:') === 0) {
        header($headerLine);
    }
}

echo $image; // Output the image content stored in $image
exit;
?>