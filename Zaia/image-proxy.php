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


// extraaaa 
// header("Access-Control-Allow-Origin: *");

// if (!isset($_GET['url'])) {
//     http_response_code(400);
//     echo "Missing 'url' parameter.";
//     exit;
// }

// $url = $_GET['url'];
// if (!filter_var($url, FILTER_VALIDATE_URL) || !in_array(parse_url($url, PHP_URL_SCHEME), ['http', 'https'])) {
//     http_response_code(400);
//     echo "Invalid URL.";
//     exit;
// }

// // Proxy list (only used if direct fetch fails)
// $proxies = [
//     '47.250.51.110:1234',
//     '18.60.103.194:3128',
//     '141.101.120.38:80',
//     '139.99.237.62:80'
// ];

// function fetchImage($url, $proxy = null) {
//     $ch = curl_init($url);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
//     curl_setopt($ch, CURLOPT_HEADER, true);
//     curl_setopt($ch, CURLOPT_TIMEOUT, 15);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

//     if ($proxy) {
//         curl_setopt($ch, CURLOPT_PROXY, $proxy);
//     }

//     $response = curl_exec($ch);
//     $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//     $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
//     $error = curl_error($ch);

//     curl_close($ch);

//     return [
//         'success' => $response !== false && $httpCode === 200,
//         'response' => $response,
//         'httpCode' => $httpCode,
//         'headerSize' => $headerSize,
//         'error' => $error
//     ];
// }

// // 1. Try without proxy (server IP)
// $result = fetchImage($url);

// if (!$result['success']) {
//     // Log server IP failure
//     file_put_contents("proxy-error.log", "[" . date('Y-m-d H:i:s') . "] Server IP failed | Error: {$result['error']} | HTTP: {$result['httpCode']} | URL: $url\n", FILE_APPEND);

//     // 2. Try each proxy
//     foreach ($proxies as $proxy) {
//         $result = fetchImage($url, $proxy);

//         if ($result['success']) {
//             break;
//         }

//         // Log each failed proxy
//         file_put_contents("proxy-error.log", "[" . date('Y-m-d H:i:s') . "] Proxy failed: $proxy | Error: {$result['error']} | HTTP: {$result['httpCode']} | URL: $url\n", FILE_APPEND);
//     }
// }

// if (!$result['success']) {
//     http_response_code(502);
//     echo "Failed to fetch image.";
//     exit;
// }

// // Extract headers and body
// $headers = substr($result['response'], 0, $result['headerSize']);
// $image = substr($result['response'], $result['headerSize']);

// // Forward relevant headers
// foreach (explode("\r\n", $headers) as $headerLine) {
//     if (stripos($headerLine, 'Content-Type:') === 0) {
//         header($headerLine);
//     }
//     if (stripos($headerLine, 'Cache-Control:') === 0) {
//         header($headerLine);
//     }
//     if (stripos($headerLine, 'Expires:') === 0) {
//         header($headerLine);
//     }
// }

// echo $image;
// exit;


// header("Access-Control-Allow-Origin: *");

// if (!isset($_GET['url'])) {
//     http_response_code(400);
//     echo "Missing 'url' parameter.";
//     exit;
// }

// $url = $_GET['url'];
// if (!filter_var($url, FILTER_VALIDATE_URL) || !in_array(parse_url($url, PHP_URL_SCHEME), ['http', 'https'])) {
//     http_response_code(400);
//     echo "Invalid URL.";
//     exit;
// }


// $proxies = [
//     ['ip' => '47.250.51.110:1234'], // No auth
//     ['ip' => '18.60.103.194:3128'], // No auth
//     ['ip' => '141.101.120.38:80', 'auth' => 'username:password'], 
//     ['ip' => '139.99.237.62:80', 'auth' => 'username:password']   
// ];

// function fetchImage($url, $proxy = null, $auth = null) {
//     $ch = curl_init($url);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
//     curl_setopt($ch, CURLOPT_HEADER, true);
//     curl_setopt($ch, CURLOPT_TIMEOUT, 15);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

//     if ($proxy) {
//         curl_setopt($ch, CURLOPT_PROXY, $proxy);
//         if ($auth) {
//             curl_setopt($ch, CURLOPT_PROXYUSERPWD, $auth);
//         }
//     }

//     $response = curl_exec($ch);
//     $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//     $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
//     $error = curl_error($ch);

//     curl_close($ch);

//     return [
//         'success' => $response !== false && $httpCode === 200,
//         'response' => $response,
//         'httpCode' => $httpCode,
//         'headerSize' => $headerSize,
//         'error' => $error
//     ];
// }

// // Start log separator
// file_put_contents("proxy-error.log", "\n+++++++++++++++++++++++++++++++++++++++++++++++++++++++++\n", FILE_APPEND);

// file_put_contents("proxy-error.log", "[" . date('Y-m-d H:i:s') . "] NEW REQUEST: $url\n", FILE_APPEND);

// // 1. Try without proxy (server IP)
// $result = fetchImage($url);

// if (!$result['success']) {
//     file_put_contents("proxy-error.log", "[" . date('Y-m-d H:i:s') . "] Server IP failed | Error: {$result['error']} | HTTP: {$result['httpCode']} | URL: $url\n", FILE_APPEND);

//     // 2. Try each proxy with rotation
//     foreach ($proxies as $proxyInfo) {
//         $proxyIP = $proxyInfo['ip'];
//         $auth = $proxyInfo['auth'] ?? null;

//         $result = fetchImage($url, $proxyIP, $auth);

//         if ($result['success']) {
//             file_put_contents("proxy-error.log", "[" . date('Y-m-d H:i:s') . "] Proxy success: $proxyIP | HTTP: {$result['httpCode']} | URL: $url\n", FILE_APPEND);
//             break;
//         }

//         // Log each failed proxy
//         file_put_contents("proxy-error.log", "[" . date('Y-m-d H:i:s') . "] Proxy failed: $proxyIP | Error: {$result['error']} | HTTP: {$result['httpCode']} | URL: $url\n", FILE_APPEND);
//     }
// }

// file_put_contents("proxy-error.log", "+++++++++++++++++++++++++++++++++++++++++++++++++++++++++\n\n", FILE_APPEND);

// if (!$result['success']) {
//     http_response_code(502);
//     echo "Failed to fetch image.";
//     exit;
// }

// // Extract headers and body
// $headers = substr($result['response'], 0, $result['headerSize']);
// $image = substr($result['response'], $result['headerSize']);

// // Forward relevant headers
// foreach (explode("\r\n", $headers) as $headerLine) {
//     if (stripos($headerLine, 'Content-Type:') === 0) {
//         header($headerLine);
//     }
//     if (stripos($headerLine, 'Cache-Control:') === 0) {
//         header($headerLine);
//     }
//     if (stripos($headerLine, 'Expires:') === 0) {
//         header($headerLine);
//     }
// }

// echo $image;
// exit;






// header("Access-Control-Allow-Origin: *");

// if (!isset($_GET['url'])) {
//     http_response_code(400);
//     echo "Missing 'url' parameter.";
//     exit;
// }

// $url = $_GET['url'];
// if (!filter_var($url, FILTER_VALIDATE_URL) || !in_array(parse_url($url, PHP_URL_SCHEME), ['http', 'https'])) {
//     http_response_code(400);
//     echo "Invalid URL.";
//     exit;
// }

// $logFile = 'proxy-error.log';
// file_put_contents($logFile, "+++++++++++++++++++++++++++++++++++++++++++++++++++++++++\n", FILE_APPEND);
// file_put_contents($logFile, "[" . date('Y-m-d H:i:s') . "] NEW REQUEST: $url\n", FILE_APPEND);

// $proxies = [
//     '47.250.51.110:1234',
//     '18.60.103.194:3128',
//     '141.101.120.38:80',
//     '139.99.237.62:80'
// ];

// function fetchImage($url, $proxy = null) {
//     $ch = curl_init($url);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
//     curl_setopt($ch, CURLOPT_HEADER, true);
//     curl_setopt($ch, CURLOPT_TIMEOUT, 15);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

//     if ($proxy) {
//         curl_setopt($ch, CURLOPT_PROXY, $proxy);
//     }

//     $response = curl_exec($ch);
//     $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//     $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
//     $error = curl_error($ch);

//     curl_close($ch);

//     return [
//         'success' => $response !== false && $httpCode === 200,
//         'response' => $response,
//         'httpCode' => $httpCode,
//         'headerSize' => $headerSize,
//         'error' => $error
//     ];
// }

// // 1. Try direct (server IP)
// $result = fetchImage($url);
// if (!$result['success']) {
//     file_put_contents($logFile, "[" . date('Y-m-d H:i:s') . "] Server IP failed | Error: {$result['error']} | HTTP: {$result['httpCode']} | URL: $url\n", FILE_APPEND);

//     // 2. Try proxy rotation
//     foreach ($proxies as $proxy) {
//         $result = fetchImage($url, $proxy);

//         if ($result['success']) {
//             break;
//         }

//         file_put_contents($logFile, "[" . date('Y-m-d H:i:s') . "] Proxy failed: $proxy | Error: {$result['error']} | HTTP: {$result['httpCode']} | URL: $url\n", FILE_APPEND);
//     }
// }

// // 3. Fallback to Puppeteer if all else fails
// if (!$result['success']) {
//     $escapedUrl = escapeshellarg($url);
//     $outputPath = __DIR__ . '/output.jpg';

//     $cmd = "node fetch-image.js $escapedUrl $outputPath";
//     exec($cmd, $output, $returnVar);

//     if (file_exists($outputPath)) {
//         header("Content-Type: image/jpeg");
//         readfile($outputPath);
//         unlink($outputPath);
//         file_put_contents($logFile, "[" . date('Y-m-d H:i:s') . "] ✅ Fetched using Puppeteer\n", FILE_APPEND);
//         file_put_contents($logFile, "+++++++++++++++++++++++++++++++++++++++++++++++++++++++++\n", FILE_APPEND);
//         exit;
//     } else {
//         file_put_contents($logFile, "[" . date('Y-m-d H:i:s') . "] ❌ Puppeteer failed for URL: $url\n", FILE_APPEND);
//         file_put_contents($logFile, "+++++++++++++++++++++++++++++++++++++++++++++++++++++++++\n", FILE_APPEND);
//         http_response_code(502);
//         echo "Failed to fetch image.";
//         exit;
//     }
// }

// // 4. Return response (if successful from direct or proxy)
// $headers = substr($result['response'], 0, $result['headerSize']);
// $image = substr($result['response'], $result['headerSize']);

// foreach (explode("\r\n", $headers) as $headerLine) {
//     if (stripos($headerLine, 'Content-Type:') === 0 ||
//         stripos($headerLine, 'Cache-Control:') === 0 ||
//         stripos($headerLine, 'Expires:') === 0) {
//         header($headerLine);
//     }
// }

// file_put_contents($logFile, "[" . date('Y-m-d H:i:s') . "] ✅ Image fetched successfully\n", FILE_APPEND);
// file_put_contents($logFile, "+++++++++++++++++++++++++++++++++++++++++++++++++++++++++\n", FILE_APPEND);
// echo $image;
// exit;

?>