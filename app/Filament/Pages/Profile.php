<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;
use Illuminate\Support\Carbon;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Profile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $title = 'Profile';
    protected static ?string $slug = 'profile';

    public ?array $avatarData = [];

    protected string $view = 'filament.pages.profile';

    public string $name;
    public string $email;
    public string $no_hp;

    public ?string $current_password = null;
    public ?string $password = null;
    public ?string $password_confirmation = null;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function mount(): void
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
        $this->no_hp = auth()->user()->no_hp ?? '';
        
        $this->form->fill([
            'avatar_url' => auth()->user()->avatar_url,
        ]);
    }

    public function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema->components([
            FileUpload::make('avatar_url')
                ->disk('public')
                ->hiddenLabel()
                ->avatar()
                ->imageEditor()
                ->circleCropper()
                ->directory('avatars')
                ->extraAttributes(['style' => 'margin: 0 auto;'])
        ])->statePath('avatarData');
    }

    public function getSessions(): array
    {
        $sessions = DB::table('sessions')
            ->where('user_id', auth()->id())
            ->orderByDesc('last_activity')
            ->get();

        $currentSessionId = session()->getId();

        return $sessions->map(function ($session) use ($currentSessionId) {
            $ua = $session->user_agent ?? '';

            return [
                'id' => $session->id,
                'is_current' => $session->id === $currentSessionId,
                'ip_address' => $session->ip_address ?? 'Tidak diketahui',
                'device' => $this->parseDevice($ua),
                'browser' => $this->parseBrowser($ua),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                'is_active_now' => (time() - $session->last_activity) < 300,
            ];
        })->toArray();
    }

    private function parseDevice(string $ua): string
    {
        if (str_contains($ua, 'Android')) return 'Android';
        if (str_contains($ua, 'iPhone')) return 'iPhone';
        if (str_contains($ua, 'iPad')) return 'iPad';
        if (str_contains($ua, 'Macintosh')) return 'macOS';
        if (str_contains($ua, 'Windows')) return 'Windows';
        if (str_contains($ua, 'Linux')) return 'Linux';
        if (str_contains($ua, 'CrOS')) return 'Chrome OS';
        return 'Tidak diketahui';
    }

    private function parseBrowser(string $ua): string
    {
        if (str_contains($ua, 'Edg/') || str_contains($ua, 'Edge')) return 'Edge';
        if (str_contains($ua, 'OPR') || str_contains($ua, 'Opera')) return 'Opera';
        if (str_contains($ua, 'Brave')) return 'Brave';
        if (str_contains($ua, 'Vivaldi')) return 'Vivaldi';
        if (str_contains($ua, 'Chrome') && !str_contains($ua, 'Chromium')) return 'Chrome';
        if (str_contains($ua, 'Firefox')) return 'Firefox';
        if (str_contains($ua, 'Safari') && !str_contains($ua, 'Chrome')) return 'Safari';
        return 'Tidak diketahui';
    }

    public function logoutOtherSessions(): void
    {
        $currentSessionId = session()->getId();

        DB::table('sessions')
            ->where('user_id', auth()->id())
            ->where('id', '!=', $currentSessionId)
            ->delete();

        Notification::make()
            ->title('Berhasil keluar dari semua perangkat lain')
            ->success()
            ->send();
    }

    public function save()
    {
        $user = auth()->user();

        $user->name = $this->name;
        $user->email = $this->email;
        $user->no_hp = $this->no_hp;

        $avatarData = $this->form->getState();
        if (array_key_exists('avatar_url', $avatarData)) {
            $user->avatar_url = $avatarData['avatar_url'];
        }

        if ($this->password) {
            if (! Hash::check($this->current_password, $user->password)) {
                Notification::make()->title('Password lama salah')->danger()->send();
                return;
            }

            if ($this->password !== $this->password_confirmation) {
                Notification::make()->title('Konfirmasi password tidak cocok')->danger()->send();
                return;
            }

            $user->password = Hash::make($this->password);
        }

        $user->save();

        Notification::make()->title('Profil berhasil diperbarui')->success()->send();

        $this->current_password = null;
        $this->password = null;
        $this->password_confirmation = null;
    }
}
