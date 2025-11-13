<?php

namespace App\Console\Commands;

use App\Models\Ban;
use Illuminate\Console\Command;
use App\Models\User;

class Unban extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:unban';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $nowTime = now();

        $UserBans = Ban::where('unban_time', '>=', $nowTime)->get();

        foreach ($UserBans as $ban) {

            $user = User::find($ban->Uid);
            if ($user) {
                $user->is_baned = 0;
                $user->Bid = null;
                $user->save();

                $ban->delete();
            }
        }
    }
}
