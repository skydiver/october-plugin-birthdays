<?php

namespace Martin\Birthdays\Models;

use Model;

class Log extends Model {

    public $table = 'users_birthdays_logs';

    public $belongsTo = [
        'user' => 'RainLab\User\Models\User',
    ];

}

?>