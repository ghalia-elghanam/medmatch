<?php
use App\Http\Controllers\XrayController;

Route::post('/analyze-xray', [XrayController::class, 'analyzeXray']);