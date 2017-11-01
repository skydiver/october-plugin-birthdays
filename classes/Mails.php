<?php

namespace Martin\Birthdays\Classes;

use DB;
use Lang;
use Mail;
use Martin\Birthdays\Models\Log as BirthdaysLog;
use RainLab\User\Models\User as UserModel;

class Mails {

    public static function send() {

        // GET ALL BIRTHDAYS FOR TODAY
        $birthdays = UserModel::where(DB::raw('MONTH(birthday)'), DB::raw('MONTH(NOW())'))
            ->where(DB::raw('DAY(birthday)'), DB::raw('DAY(NOW())'))
            ->get();

        // IF NO BIRTHDAYS STOP HERE
        if (count($birthdays) == 0) {
            return Lang::get('martin.birthdays::lang.console.empty');
        }

        // YEAR TO SEND
        $year = date('Y');

        // SAVE RESULT
        $result = [];

        // START SENDING EMAILS
        foreach ($birthdays as $user) {

            // GET EMAILS LOG
            $log = BirthdaysLog::where('user_id', $user->id)
                ->where('status', Lang::get('martin.birthdays::lang.console.cols.ok'))
                ->where('year', $year)
                ->first();

            // SKIP IF ALREADY SENT
            if (!empty($log)) {
                $result[] = self::_storeResult($user, 3);
                self::_storeLog($user, Lang::get('martin.birthdays::lang.console.cols.skip'), $year);
                continue;
            }

            // SEND EMAIL
            $ok = Mail::send('martin.birthdays::mail.birthday', ['user' => $user], function ($message) use ($user) {
                $message->to($user->email, $user->name);
            });

            // STORE RESULT FOR LATER
            $status   = ($ok == 1) ? 1 : 2;
            $result[] = self::_storeResult($user, $status);

            // ADD EMAIL LOG
            $status = ($ok == 1) ? Lang::get('martin.birthdays::lang.console.cols.ok') : Lang::get('martin.birthdays::lang.console.cols.error');
            self::_storeLog($user, $status, $year);

        }

        // GET RESULT
        return $result;

    }

    private static function _storeLog($user, $status, $year) {
        $newLog = new BirthdaysLog;
        $newLog->user_id = $user->id;
        $newLog->email   = $user->email;
        $newLog->status  = $status;
        $newLog->year    = $year;
        $newLog->save();
    }

    private static function _storeResult($user, $message) {

        $messages = [
            1 => Lang::get('martin.birthdays::lang.console.cols.ok'),
            2 => Lang::get('martin.birthdays::lang.console.cols.error'),
            3 => Lang::get('martin.birthdays::lang.console.cols.skip'),
        ];

        return [
            $user->name . ' ' . $user->surname,
            $user->email,
            date('Y-m-d H:i:s'),
            $messages[$message]
        ];

    }

}

?>