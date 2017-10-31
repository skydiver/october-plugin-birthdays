<?php

namespace Martin\Birthdays\Controllers;

use App, Backend, Redirect, Response;
use Martin\Birthdays\Classes\Tokens;
use Martin\Birthdays\Models\Settings;

class Token extends \Backend\Classes\Controller {

    public function regenerate() {
        Settings::set('token', Tokens::generate());
        $URL = Backend::url('system/settings/update/martin/birthdays/settings');
        return Redirect::to($URL);
    }

}

?>