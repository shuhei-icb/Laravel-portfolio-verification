<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
	use RefreshDatabase;

	public function test_profile_page_is_displayed(): void
	{
		$user = User::factory()->create();

		$response = $this
			->actingAs($user)
			->get('/mypage');

		$response->assertOk();
	}

	public function test_profile_information_can_be_updated(): void
	{
		$user = User::factory()->create();

		$response = $this
			->actingAs($user)
			->patch('/mypage/profile', [
				'name' => 'Test User',
				'email' => 'test@example.com',
			]);

		$response
			->assertSessionHasNoErrors()
			->assertRedirect('/mypage/profile');

		$user->refresh();

		$this->assertSame('Test User', $user->name);
		$this->assertSame('test@example.com', $user->email);
		$this->assertNull($user->email_verified_at);
	}

	public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
	{
		$user = User::factory()->create();

		$response = $this
			->actingAs($user)
			->patch('/mypage/profile', [
				'name' => 'Test User',
				'email' => $user->email,
			]);

		$response
			->assertSessionHasNoErrors()
			->assertRedirect('/mypage/profile');

		$this->assertNotNull($user->refresh()->email_verified_at);
	}

	public function test_user_can_delete_their_account(): void
	{
		$user = User::factory()->create();

		$response = $this
			->actingAs($user)
			->delete('/myupage/profile', [
				'password' => 'password',
			]);

		$response
			->assertSessionHasNoErrors()
			->assertRedirect('/');

		$this->assertGuest();
		$this->assertNull($user->fresh());
	}

	public function test_correct_password_must_be_provided_to_delete_account(): void
	{
		$user = User::factory()->create();

		$response = $this
			->actingAs($user)
			->from('/mypage/profile')
			->delete('/mypage/profile', [
				'password' => 'wrong-password',
			]);

		$response
			->assertSessionHasErrors('password')
			->assertRedirect('/mypage/profile');

		$this->assertNotNull($user->fresh());
	}
}
