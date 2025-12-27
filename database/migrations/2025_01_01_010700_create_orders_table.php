<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('status')->default('new');
            $table->string('customer_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('shipping_cost', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->string('shipping_provider')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_ref')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('promo_code')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
