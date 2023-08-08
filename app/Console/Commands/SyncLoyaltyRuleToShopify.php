<?php

namespace App\Console\Commands;

use App\Models\LoyaltyRule;
use App\Models\User;
use Illuminate\Console\Command;

class SyncLoyaltyRuleToShopify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-loyalty-rule-to-shopify {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync loyalty rules to shopify';

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
            $user->loyaltyRules()->chunk(50, function ($loyalty_rules) {
                foreach ($loyalty_rules as $loyalty_rule) {
                    try {
                        $loyalty_rule->syncMetafield();
                    } catch (\Exception $e) {
                        $this->error("Can not sync metafield for rule {$loyalty_rule->id}, error: {$e->getMessage()}");
                    }
                }
            });
        } else {
            LoyaltyRule::chunk(50, function ($loyalty_rules) {
                foreach ($loyalty_rules as $loyalty_rule) {
                    try {
                        $loyalty_rule->syncMetafield();
                    } catch (\Exception $e) {
                        $this->error("Can not sync metafield for rule {$loyalty_rule->id}, error: {$e->getMessage()}");
                    }
                }
            });
        }
    }
}
