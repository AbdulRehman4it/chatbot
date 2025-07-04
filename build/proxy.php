<?php
header("Access-Control-Allow-Origin: *"); // For development only. Change to your domain later
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);

$prompt = $input["prompt"] ?? null;
$userId = $input["userId"] ?? null;
$sessionId = $input["sessionId"] ?? null;

if (!$prompt || !$userId || !$sessionId) {
    http_response_code(400);
    echo json_encode(["error" => "Missing required fields"]);
    exit;
}

$agentId = "1acefbf8-6b7c-4ef9-af9e-32dc00029a48";
$apiKey = "61597eab559ac4fb3b71242b7f88fe8c";

$payload = json_encode([
    "agentId" => $agentId,
    "userId" => $userId,
    "sessionId" => $sessionId,
    "prompt" => $prompt
]);

$ch = curl_init("https://agent-kinkybunny.aag.systems/api/interact");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "x-api-key: $apiKey",
    "Accept: application/json"
]);
curl_setopt($ch, CURLOPT_TIMEOUT, 60); 
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

http_response_code($httpCode);
if ($response === false) {
    echo json_encode(["error" => "Curl failed", "details" => $error]);
} else {
    echo $response;
}
