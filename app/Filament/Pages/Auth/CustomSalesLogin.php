<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;

class CustomSalesLogin extends BaseLogin
{
    protected string $view = 'filament.pages.auth.custom-sales-login';
    protected static string $layout = 'filament-panels::components.layout.base';
}
