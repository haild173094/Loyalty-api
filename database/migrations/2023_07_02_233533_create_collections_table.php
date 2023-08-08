<?php

use App\Enums\CollectionStatus;
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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shopify_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('loyalty_point')->default(0);
            $table->string('title');
            $table->string('image_src')->nullable();
            $table->integer('status')->default(CollectionStatus::Published->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
