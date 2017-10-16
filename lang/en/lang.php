<?php

return [

    'plugin' => [
        'name'        => 'Birthdays',
        'description' => 'Send birthday mails to your users',
    ],

    'fields' => [
        'birthday' => 'Birthday'
    ],

    'mails' => [
        'birthday' => [
            'description' => 'Birthday email',
        ],
    ],

    'console' => [
        'empty' => 'There is no birthdays',
        'cols'  => [
            'user'   => 'User',
            'email'  => 'Email',
            'date'   => 'Date',
            'status' => 'Status',
            'ok'     => 'OK',
            'error'  => 'Error',
        ],
    ],

];