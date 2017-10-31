<?php

namespace Martin\Birthdays\Classes;

use DB;
use Lang;
use Mail;
use RainLab\User\Models\User as UserModel;

class Mails {

    public static function send() {

        // GET ALL BIRTHDAYS FOR TODAY
        $birthdays = UserModel::where(DB::raw('MONTH(birthday)'), DB::raw('MONTH(NOW())'))
            // ->where(DB::raw('DAY(birthday)'), DB::raw('DAY(NOW())'))
            ->get();

        // IF NO BIRTHDAYS STOP HERE
        if (count($birthdays) == 0) {
            return Lang::get('martin.birthdays::lang.console.empty');
        }

        // SAVE RESULT
        $result = [];

        // START SENDING EMAILS
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

        }

        // GET RESULT
        return $result;

    }

}

?>