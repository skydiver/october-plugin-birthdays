<?php

namespace Martin\Birthdays\Updates;

use Seeder;
use Martin\Birthdays\Classes\Tokens;
use Martin\Birthdays\Models\Settings;

class SeedDefaultToken extends Seeder {

    public function run() {
        Settings::set('token', Tokens::generate());
    }

}

?>