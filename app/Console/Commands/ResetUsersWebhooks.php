<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Osiset\ShopifyApp\Actions\DispatchWebhooks;
use App\Models\User;

class ResetUsersWebhooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-users-webhooks {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset users webhooks';

    /**
     * Execute the console command.
     */
    public function handle(DispatchWebhooks $dispatchWebhooksAction)
    {
        $id = $this->option('id');

        if ($id) {
            $user = User::find($id);
            if (!$user) {
                $this->error("User not found");
                return;
            }
        } else {
            if ($this->confirm("Are you sure want to reset all users' webhooks?", false)) {
                User::chunk(50, function ($users) use ($dispatchWebhooksAction) {
                    foreach ($users as $user) {
                        try {
                            call_user_func($dispatchWebhooksAction, $user->getId(), true);
                            $this->info("User " . $user->id . " domain " . $user->name . " done");
                        } catch (\Exception $e) {
                            \Log::error($e);

                            $this->error("Failed to reset webhook of user " . $user->id . " domain " . $user->name . " error " . $e->getMessage());
                        }
                    }
                });
                $this->info("DONE");
            }
        }
    }
}
