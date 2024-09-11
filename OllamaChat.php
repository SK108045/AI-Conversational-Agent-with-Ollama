<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

$question = $_POST['question'];
$command = 'cd /home/johnkahuria99/.ollama && ollama run gemma:2b ' . escapeshellarg($question);
$output = shell_exec($command);

$response = [];
if ($output === null) {
    $response['status'] = 'error';
    $response['message'] = 'Command execution failed.';
} else {
    $response['status'] = 'success';
    $response['output'] = nl2br(htmlspecialchars($output));
}

echo json_encode($response);
?>
