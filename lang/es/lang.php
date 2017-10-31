<?php

return [

    'plugin' => [
        'name'        => 'Saludo de Cumpleaños',
        'description' => 'Envía un email con saludo de cumpleaños a los usuarios del sistema',
    ],

    'fields' => [
        'birthday' => 'Fecha de nacimiento'
    ],

    'mails' => [
        'birthday' => [
            'description' => 'Saludo de cumpleaños',
        ],
    ],

    'settings' => [
        'label'       => 'Cumpleaños',
    ],

    'permissions' => [
        'label' => 'Administrar la configuración de cumpleaños',
    ],

];