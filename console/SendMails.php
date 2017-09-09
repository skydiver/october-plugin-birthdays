<?php

namespace Martin\Birthdays\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SendMails extends Command {

    protected $name = 'birthdays:sendmails';
    protected $description = 'Check for birthdats and send emails';

    public function fire() {
        $this->output->writeln('Hello world!');
    }

    protected function getArguments() {
        return [];
    }

    protected function getOptions() {
        return [];
    }

}

?>