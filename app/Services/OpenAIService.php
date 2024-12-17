<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class OpenAIService
{
protected $apiKey;
public function __construct()
{
// Set the API key from the .env file
$this->apiKey = env('OPENAI_API_KEY');
Log::info('OpenAI API key loaded.');
}
// Function to encode the image into Base64
public function encodeImage($imagePath)
{
Log::info('Encoding image to Base64.', ['image' => $imagePath]);
$imageData = file_get_contents($imagePath);
if ($imageData === false) {
Log::error('Failed to read image file.', ['image' => $imagePath]);
return null;
}
return base64_encode($imageData);
}
// This is the analyzeXRayImage method
public function analyzeXRayImage($imagePaths) 
{
Log::info('Starting image analysis for multiple images.', ['imagePaths' => $imagePaths]);
$messages = [
[
'role' => 'system',
'content' => 'You are a helpful assistant for analyzing images.',
],
];
// Add each image to the messages array
foreach ($imagePaths as $imagePath) {
$base64Image = $this->encodeImage($imagePath);
if ($base64Image === null) {
Log::error('Failed to encode image to Base64.', ['image' => $imagePath]);
return 'Error: Failed to process one or more images.';
}
$messages[] = [
'role' => 'user',
'content' => [
[
'type' => 'image_url',
'image_url' => [
'url' => "data:image/jpeg;base64,$base64Image",
],
],
],
];
}
// Prepare the request payload
$requestPayload = [
'model' => 'gpt-4-turbo', // Use any correct model name
'messages' => $messages,
'max_tokens' => 300,
];
// Send a POST request to the OpenAI API for image analysis
try {
Log::info('Sending POST request to OpenAI API for image analysis.');
$response = Http::timeout(30)->withHeaders([
'Authorization' => 'Bearer ' . $this->apiKey,
])->post('https://api.openai.com/v1/chat/completions', $requestPayload);
// Check if the response is successful
if ($response->successful()) {
$data = $response->json();
Log::info('OpenAI API response received successfully.', ['response' => $data]);
return $data['choices'][0]['message']['content'] ?? 'No analysis result.';
} else {
Log::error('OpenAI API request failed.', [
'status' => $response->status(),
'response' => $response->body(),
]);
return 'Error: ' . $response->status() . ' - ' . $response->body();
}
} catch (\Exception $e) {
Log::error('Error while sending request to OpenAI API.', ['error' => $e->getMessage()]);
return 'Error while sending request to OpenAI API.';
}
}
}
