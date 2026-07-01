<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;

class CustomSalesLogin extends BaseLogin
{
    protected string $view = 'filament.pages.auth.custom-sales-login';
    protected static string $layout = 'filament-panels::components.layout.base';

    protected function getEmailFormComponent(): \Filament\Schemas\Components\Component
    {
        return \Filament\Forms\Components\TextInput::make('login')
            ->label('Email atau Username')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getCredentialsFromFormData(#[\SensitiveParameter] array $data): array
    {
        $login_type = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        return [
            $login_type => $data['login'],
            'password'  => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'data.login' => __('filament-panels::auth/pages/login.messages.failed'),
        ]);
    }
}
