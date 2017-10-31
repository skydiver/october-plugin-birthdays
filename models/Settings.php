<?php

namespace Martin\Birthdays\Models;

use Model;

class Settings extends Model {

    use \October\Rain\Database\Traits\Validation;

    public $rules = [
    ];

    public $attributeNames;
    public $implement      = ['System.Behaviors.SettingsModel'];
    public $settingsCode   = 'martin_birthdays_settings';
    public $settingsFields = 'fields.yaml';

}

?>