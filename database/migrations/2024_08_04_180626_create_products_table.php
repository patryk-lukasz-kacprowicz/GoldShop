<?php

use App\Models\Category;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'patron_id');
            $table->foreignIdFor(Category::class, 'category_id');
            $table->foreignIdFor(Stock::class, 'stock_id');
            $table->boolean('is_active')->default(false)->nullable();
            $table->boolean('is_in_stock')->default(false)->nullable();
            $table->boolean('is_trend')->default(false)->nullable();
            $table->boolean('has_max_cart')->default(false)->nullable();
            $table->integer('min_cart')->nullable();
            $table->integer('max_cart')->nullable();
            $table->boolean('has_stock_alert')->default(false)->nullable();
            $table->integer('min_stock')->nullable();
            $table->integer('max_stock')->nullable();
            $table->boolean('has_unlimited_stock')->default(false)->nullable();
            $table->string('name', 255)->unique();
            $table->string('slug', 255)->unique();
            $table->string('sku')->unique();
            $table->string('barcode')->unique();
            $table->float('price');
            $table->float('vat');
            $table->integer('discount');
            $table->string('image');
            $table->text('description');
            $table->text('details');
            $table->string('type');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
