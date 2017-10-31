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

    'settings' => [
        'label'          => 'Birthdays',
        'url'            => 'Cron URL',
        'token'          => 'Security Token',
        'token_comments' => 'Security code to access Cron URL',
        'regenerate'     => 'Regenerate Token',
    ],

    'permissions' => [
        'label' => 'Manage Birthdays Settings',
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
            'skip'   => 'Already sent'
        ],
    ],

];