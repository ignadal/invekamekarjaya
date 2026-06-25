<?php

namespace App\Filament\Sales\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function getColumns(): int | array
    {
        return 3;
    }
}
