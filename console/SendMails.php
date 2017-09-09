<?php

namespace Martin\Birthdays\Console;

use DB;
use Mail;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use RainLab\User\Models\User as UserModel;

class SendMails extends Command {

    protected $name = 'birthdays:sendmails';
    protected $description = 'Check for birthdays and send emails';

    public function fire() {

        $birthdays = UserModel::where(DB::raw('MONTH(birthday)'), DB::raw('MONTH(NOW())'))
            ->where(DB::raw('DAY(birthday)'), DB::raw('DAY(NOW())'))
            ->get();

        foreach ($birthdays as $user) {
            Mail::send('martin.birthdays::mail.birthday', [$user], function ($message) use ($user) {
                $message->to($user->email, $user->name);
            });
        }

    }

    protected function getArguments() {
        return [];
    }

    protected function getOptions() {
        return [];
    }

}

?>