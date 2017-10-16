<?php

namespace Martin\Birthdays\Console;

use DB;
use Lang;
use Mail;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use RainLab\User\Models\User as UserModel;

class SendMails extends Command {

    protected $name        = 'birthdays:sendmails';
    protected $description = 'Check for birthdays and send emails';

    public function fire() {

        $birthdays = UserModel::where(DB::raw('MONTH(birthday)'), DB::raw('MONTH(NOW())'))
            ->where(DB::raw('DAY(birthday)'), DB::raw('DAY(NOW())'))
            ->get();

        if (empty($birthdays)) {
            return $this->info(Lang::get('martin.birthdays::lang.console.empty'));
        }

        $result = [];
        $bar = $this->output->createProgressBar(count($birthdays));


        foreach ($birthdays as $user) {

            // GET EMAILS LOG
            $log = (!is_array($user->birthday_log)) ? [] : $user->birthday_log;

            // SKIP IF ALREADY SENT
            if ($log != '' && array_key_exists(date('Y'), $log)) {
                $result[] = [
                    $user->name . ' ' . $user->surname,
                    $user->email,
                    date('Y-m-d H:i:s'),
                    Lang::get('martin.birthdays::lang.console.cols.skip')
                ];
                continue;
            }

            // SEND EMAIL
            $ok = Mail::send('martin.birthdays::mail.birthday', ['user' => $user], function ($message) use ($user) {
                $message->to($user->email, $user->name);
            });

            // STORE RESULT FOR LATER
            $result[] = [
                $user->name . ' ' . $user->surname,
                $user->email,
                date('Y-m-d H:i:s'),
                ($ok == 1) ? Lang::get('martin.birthdays::lang.console.cols.ok') : Lang::get('martin.birthdays::lang.console.cols.error')
            ];

            // ADD EMAIL LOG
            $log[date('Y')] = date('Y-m-d H:i:s');
            $user->birthday_log = $log;
            $user->save();

            // ADVANCE PROGRESS BAR
            $bar->advance();

        }

        $bar->finish();
        echo "\n";

        $headers = [
            Lang::get('martin.birthdays::lang.console.cols.user'),
            Lang::get('martin.birthdays::lang.console.cols.email'),
            Lang::get('martin.birthdays::lang.console.cols.date'),
            Lang::get('martin.birthdays::lang.console.cols.status'),
        ];
        $this->table($headers, $result);

    }

    protected function getArguments() {
        return [];
    }

    protected function getOptions() {
        return [];
    }

}

?>