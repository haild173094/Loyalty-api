<?php

use App\Enums\DiscountApplicationType;
use App\Enums\DiscountType;
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
        Schema::create('discount_blueprints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('type')->default(DiscountType::Percentage);
            $table->double('amount');
            $table->unsignedBigInteger('loyalty_price');
            $table->string('customer_selection')->default(DiscountApplicationType::One);
            $table->unsignedBigInteger('time_limit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_blueprints');
    }
};
