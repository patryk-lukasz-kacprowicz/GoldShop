<?php

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
            $table->foreignIdFor(User::class, 'created_by')->unsigned();
            $table->foreignIdFor(User::class, 'assigned_to')->unsigned();
            $table->boolean('is_visible')->nullable()->default(false);
            $table->boolean('is_available')->nullable()->default(false);
            $table->string('thumbnail', 255);
            $table->integer('amount')->nullable()->default(0);
            $table->string('title', 255);
            $table->float('price');
            $table->text('description');
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
