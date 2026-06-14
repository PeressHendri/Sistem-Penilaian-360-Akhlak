<?php

namespace App\Filament\Auth;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required()
                    ->placeholder('name@company.com')
                    ->prefixIcon('heroicon-o-user'),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->placeholder('••••••••')
                    ->prefixIcon('heroicon-o-lock-closed')
                    ->revealable(),

                Checkbox::make('remember')
                    ->label('Remember me for 30 days'),
            ]);
    }

    public function getHeading(): string
    {
        return 'Welcome Back';
    }

    public function getSubheading(): ?string
    {
        return 'Sign in to access your dashboard';
    }

    protected function getFormActions(): array
    {
        return [
            $this->getAuthenticateFormAction()
                ->label('Sign In →')
                ->fullWidth(),
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.email' => 'Email atau password salah. Silakan coba lagi.',
        ]);
    }
}
