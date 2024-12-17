<?php
namespace App\Filament\Doctor\Widgets;
use Filament\Widgets\Widget;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use App\Services\OpenAIService;
class AnalyzeXray extends Widget
{
protected static string $view = 'filament.doctor.widgets.analyze-xray';
protected static ?int $sort = 3; // Adjust sort order if needed
protected int | string | array $columnSpan = 'full';
protected static ?string $heading = 'X-RAY Scan Assistant';
use WithFileUploads;
public $uploadedImages = []; // Store multiple uploaded images
public $analysisResults = []; // To store image paths and analysis results
protected $openAIService;
public function boot(OpenAIService $openAIService)
{
$this->openAIService = $openAIService;
}
public function analyzeImages()
{
Log::info('analyzeImages method started.');
// Check if the number of uploaded images exceeds the limit
if (count($this->uploadedImages) > 3) {
Log::warning('Too many images uploaded.');
session()->flash('error', 'You can upload a maximum of 3 images.');
return;
}
// Validate the uploaded files
if (empty($this->uploadedImages)) {
Log::warning('No images uploaded.');
session()->flash('error', 'Please upload at least one image.');
return;
}
// Validate each image
foreach ($this->uploadedImages as $image) {
if (!$image->isValid()) {
Log::warning('Invalid image detected.');
session()->flash('error', 'One or more images are invalid.');
return;
}
// Validate the image type and size
try {
$this->validate([
'uploadedImages.*' => 'image|mimes:jpg,jpeg,png|max:2048', // 2MB max per image
]);
} catch (\Exception $e) {
Log::error('Image validation failed.', ['error' => $e->getMessage()]);
session()->flash('error', 'Image validation failed. Please upload valid images.');
return;
}
}
// Temporarily store the uploaded files and analyze them
$this->analysisResults = [];
try {
foreach ($this->uploadedImages as $image) {
// Store the image in the public directory
$path = $image->store('xray_images', 'public');
$publicPath = '/storage/' . $path;
// Analyze the image using the OpenAI service
$analysisResult = $this->openAIService->analyzeXRayImage([storage_path('app/public/' . $path)]);
// Ensure the analysis result is properly formatted
$resultText = is_array($analysisResult) ? implode("\n", $analysisResult) : (string)$analysisResult;
// Store the image path and analysis result
$this->analysisResults[] = [
'image' => $publicPath,
'analysis' => $resultText,
];
Log::info('Image analyzed successfully.', [
'image' => $publicPath,
'analysis' => $resultText,
]);
}
} catch (\Exception $e) {
Log::error('Error during image analysis.', ['error' => $e->getMessage()]);
session()->flash('error', 'An error occurred while analyzing the images.');
}
}
}
