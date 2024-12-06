<?php

namespace App\Filament\Doctor\Resources\UserResource\Pages;

use App\Filament\Doctor\Resources\UserResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Http;

class AiAssistant extends Page
{
    protected static string $resource = UserResource::class;

    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'AI Tool';

    protected static ?string $navigationGroup = 'Patient';

    protected static string $view = 'filament.pages.ai-assistant';

    public function handleAiRequest(): array
    {
        $response = Http::post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a medical assistant.'],
                ['role' => 'user', 'content' => request()->input('query')],
            ],
        ], [
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ]);

        if ($response->successful()) {
            return $response->json()['choices'][0]['message']['content'];
        }

        return ['error' => 'Failed to process your request. Please try again.'];
    }
}
