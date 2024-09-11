<?php
//Should be created in the Text_to_Speech_php Folder along with the composer.json
require 'vendor/autoload.php';

use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

$data = json_decode(file_get_contents('php://input'), true);
$output = $data['output'] ?? '';

if (empty($output)) {
    echo json_encode(['status' => 'error', 'message' => 'No output provided.']);
    exit;
}

putenv('GOOGLE_APPLICATION_CREDENTIALS=path/to/your/credentials.json');

$client = new TextToSpeechClient();

$synthesisInput = new SynthesisInput();
$synthesisInput->setText($output);

$voice = new VoiceSelectionParams();
$voice->setLanguageCode('en-US');
$voice->setName('en-US-Journey-O');

$audioConfig = new AudioConfig();
$audioConfig->setAudioEncoding(AudioEncoding::MP3);

$response = $client->synthesizeSpeech($synthesisInput, $voice, $audioConfig);

file_put_contents('output.mp3', $response->getAudioContent());

echo json_encode(['status' => 'success', 'message' => 'Audio content written to file "output.mp3"']);

$client->close();
