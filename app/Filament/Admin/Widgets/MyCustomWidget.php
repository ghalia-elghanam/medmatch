<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;

class MyCustomWidget extends Widget
{
    protected static string $view = 'filament.admin.widgets.my-custom-widget';
    protected int|string|array $columnSpan = 'full';
}
