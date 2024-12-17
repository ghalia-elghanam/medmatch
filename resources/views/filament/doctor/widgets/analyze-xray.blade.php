<x-filament-widgets::widget>
<x-filament::section>
<div class="p-4">
<h2 class="text-xl font-bold mb-4 d-flex justify-center align-items-center text-center">{{ static::$heading }}</h2>
<!-- Upload Form -->
<form wire:submit.prevent="analyzeImages" class="mb-6 d-flex justify-center align-items-center text-center">
<div class="w-full d-flex justify-center align-items-center">
<input type="file" wire:model="uploadedImages" multiple accept="image/*" class="d-flex w-1/2 mb-2 border border-white border-1">
</div>
<!-- Analyze Images Button with Processing Text -->
<button type="submit"
class="py-2 px-4 rounded hover:bg-[#8c8c8c] border border-white border-1 relative"
wire:loading.attr="disabled" wire:target="analyzeImages">
<!-- Processing Text -->
<span wire:loading.remove>Analyze Images</span>
<span wire:loading class="">Processing...</span>
</button>
@error('uploadedImages.*') 
<span class="text-red-500 text-sm">{{ $message }}</span> 
@enderror
</form>
<!-- Display Uploaded Images and Analysis Results -->
@if (!empty($analysisResults))
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
@foreach ($analysisResults as $result)
<div class="border p-4 rounded shadow-lg">
<img src="{{ $result['image'] }}" alt="Uploaded Image" class="w-full h-auto mb-2">
<p class="text-sm text-white">{{ $result['analysis'] }}</p>
</div>
@endforeach
</div>
@endif
<!-- Flash Message for Errors -->
@if (session()->has('error'))
<div class="text-center mt-4 text-red-500">{{ session('error') }}</div>
@endif
</div>
</x-filament::section>
</x-filament-widgets::widget>