<?php

namespace App\Filament\Sales\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-home';

    public function getSubheading(): ?string
    {
        $name = auth()->user()->name ?? 'Sales 1';
        return "Selamat datang kembali, {$name}! 👋";
    }

    public function getColumns(): int | array
    {
        return 3;
    }
}
