<?php

namespace App\Console\Commands;

use App\Models\DiscountBlueprint;
use App\Models\User;
use Illuminate\Console\Command;

class SyncDiscountBlueprintToShopify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-discount-blueprint-to-shopify {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync discount blueprint to shopify';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->option('id');

        if ($id) {
            $user = User::find($id);
            if (!$user) {
                $this->error("User not found");
                return;
            }
            $user->discountBlueprints()->chunk(50, function ($discount_blueprints) {
                foreach ($discount_blueprints as $discount_blueprint) {
                    try {
                        $discount_blueprint->syncMetafield();
                    } catch (\Exception $e) {
                        $this->error("Can not sync metafield for blueprint {$discount_blueprint->id}, error: {$e->getMessage()}");
                    }
                }
            });
        } else {
            DiscountBlueprint::chunk(50, function ($discount_blueprints) {
                foreach ($discount_blueprints as $discount_blueprint) {
                    try {
                        $discount_blueprint->syncMetafield();
                    } catch (\Exception $e) {
                        $this->error("Can not sync metafield for blueprint {$discount_blueprint->id}, error: {$e->getMessage()}");
                    }
                }
            });
        }
    }
}
