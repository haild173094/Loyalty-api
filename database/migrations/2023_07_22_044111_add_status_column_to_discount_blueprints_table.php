<?php

use App\Enums\DiscountBlueprintStatus;
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
        Schema::table('discount_blueprints', function (Blueprint $table) {
            $table->integer('status')->default(DiscountBlueprintStatus::Published->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discount_blueprints', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
