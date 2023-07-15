<?php

use App\Enums\LoyaltyRuleApplicationType;
use App\Enums\LoyaltyRuleStatus;
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
        Schema::create('loyalty_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('shopify_id');
            $table->string('name');
            $table->unsignedInteger('loyalty_point');
            $table->string('type')->default(LoyaltyRuleApplicationType::Product);
            $table->integer('status')->default(LoyaltyRuleStatus::Published);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_rules');
    }
};
