<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
  use RefreshDatabase;

  public function test_registration_screen_can_be_rendered(): void
  {
    $response = $this->get('/register');

    $response->assertStatus(200);
  }

  public function test_new_users_can_register_without_address(): void
  {
    $response = $this->post('/register', [
      'name' => 'テストユーザー',
      'email' => 'test@example.com',
      'password' => 'password123',
      'password_confirmation' => 'password123',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('mypage.index'));
    $this->assertDatabaseHas('users', [
      'email' => 'test@example.com',
      'name' => 'テストユーザー',
    ]);
  }

  public function test_new_users_can_register_with_address(): void
  {
    $response = $this->post('/register', [
      'name' => 'テストユーザー',
      'email' => 'test@example.com',
      'zip' => '1000001',
      'prefecture' => '東京都',
      'city' => '千代田区千代田',
      'address' => '1-1',
      'password' => 'password123',
      'password_confirmation' => 'password123',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('mypage.index'));
    $this->assertDatabaseHas('users', [
      'email' => 'test@example.com',
      'name' => 'テストユーザー',
    ]);
  }

  public function test_new_users_can_not_register_empty(): void {
    $response = $this->withHeader('referer', '/register')->post('/register', [
      'name' => '',
      'email' => '',
      'password' => '',
      'password_confirmation' => '',
    ]);

    $response->assertRedirect('/register');
    $response->assertSessionHasErrors(['name', 'email', 'password']);
    $this->assertGuest();
  }
}
