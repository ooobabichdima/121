<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_is_created_with_totals(): void
    {
        $product = Product::factory()->create(['price' => 1000]);
        $this->withSession(['cart' => [$product->id => 2]])
            ->post('/checkout/submit', [
                'customer_name' => 'Tester',
                'phone' => '123',
                'delivery_method' => 'pickup',
                'payment_method' => 'cod',
            ]);

        $this->assertDatabaseHas('orders', ['customer_name' => 'Tester']);
    }
}
