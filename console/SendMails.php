<?php

namespace Martin\Birthdays\Console;

use Lang;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Martin\Birthdays\Classes\Mails;

class SendMails extends Command {

    protected $name        = 'birthdays:sendmails';
    protected $description = 'Check for birthdays and send emails';

    public function fire() {

        // SEND MAILS
        $result = Mails::send();

        // TABLE HEADERS
        $headers = [
            Lang::get('martin.birthdays::lang.console.cols.user'),
            Lang::get('martin.birthdays::lang.console.cols.email'),
            Lang::get('martin.birthdays::lang.console.cols.date'),
            Lang::get('martin.birthdays::lang.console.cols.status'),
        ];

        // SHOW RESULT
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