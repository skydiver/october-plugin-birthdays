<?php

namespace Martin\Birthdays\Controllers;

use Artisan;
use Response;
use Illuminate\Routing\Controller;
use Martin\Birthdays\Classes\Mails;

class CronController extends Controller {

    public function cron() {

        // $command = Artisan::call('env');

        $result = Mails::send();

        return Response::json($result);

    }

}

?>