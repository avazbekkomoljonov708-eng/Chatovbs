<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LanguageSettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_language_is_applied_as_current_app_locale(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'settings' => ['language' => 'uz'],
        ]);

        $this->actingAs($user)
            ->patch('/settings', [
                'theme' => 'dark',
                'language' => 'ru',
            ]);

        $this->assertSame('ru', app()->getLocale());
        $this->assertSame('ru', session('app_locale'));
        $this->assertSame('ru', $user->fresh()->settings['language'] ?? null);
    }
}
