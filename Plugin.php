<?php

namespace Martin\Birthdays;

use File;
use Lang;
use Yaml;
use System\Classes\PluginBase;
use RainLab\User\Models\User as UserModel;
use RainLab\User\Controllers\Users as UsersController;

class Plugin extends PluginBase {

    public $require = ['RainLab.User'];

    public function pluginDetails() {
        return [
            'name'        => 'martin.birthdays::lang.plugin.name',
            'description' => 'martin.birthdays::lang.plugin.description',
            'author'      => 'Martin M.',
            'icon'        => 'icon-birthday-cake',
        ];
    }

    public function boot() {

        UserModel::extend(function ($model) {
            $model->addFillable(['birthday']);
        });

        UsersController::extendFormFields(function ($widget, $model, $context) {
            $configFile = __DIR__ . '/config/profile_fields.yaml';
            $config = Yaml::parse(File::get($configFile));
            $widget->addTabFields($config);
        });

    }

    public function register() {
        $this->registerConsoleCommand('birthdays.sendmails', 'Martin\Birthdays\Console\SendMails');
    }

    public function registerMailTemplates() {
        return [
            'martin.birthdays::mail.birthday' => Lang::get('martin.birthdays::lang.mails.birthday.description'),
        ];
    }

}

?>