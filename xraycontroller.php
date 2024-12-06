<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Client;

class xraycontroller extends Controller
{
    public function analyzeXray(Request $request)
    {
        $request->validate([
            'xray_image' => 'required|file|mimes:jpg,jpeg,png',
        ]);

        $xrayData = $this->processXray($request->file('xray_image'));

        $client = new Client(['api_key' => env('OPENAI_API_KEY')]);

        $response = $client->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a medical AI assistant.'],
                ['role' => 'user', 'content' => "Analyze the following X-ray image and briefly describe any abnormalities: " . $xrayData]
            ],
            'max_tokens' => 150,
            'temperature' => 0.5,
        ]);

        return response()->json(['analysis' => $response['choices'][0]['message']['content']]);
    }

    private function processXray($image)
    {
        return "Processed X-ray image data";
    }
}
