<?php

namespace Tests\Feature\Shop;

use App\Models\Shop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/shop/login');
        $response->assertStatus(200);
    }

    public function test_shops_can_authenticate_using_the_login_screen(): void
    {
        $shop = Shop::factory()->create();

        $response = $this->post('/shop/login', [
            'email' => $shop->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($shop, 'shop');
        $response->assertRedirect('/shop/dashboard');
    }

    public function test_shops_can_not_authenticate_with_invalid_password(): void
    {
        $shop = Shop::factory()->create();

        $this->post('/shop/login', [
            'email' => $shop->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_shops_can_logout(): void
    {
        $shop = Shop::factory()->create();

        $response = $this->actingAs($shop, 'shop')->post('/shop/logout');

        $this->assertGuest('shop');
        $response->assertRedirect('/shop/login');
    }
}
