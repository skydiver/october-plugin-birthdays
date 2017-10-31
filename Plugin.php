<?php

namespace Martin\Birthdays;

use File;
use Lang;
use Yaml;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;
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
            $model->addJsonable(['birthday_log']);
        });

        UsersController::extendFormFields(function ($widget, $model, $context) {
            $configFile = __DIR__ . '/config/profile_fields.yaml';
            $config = Yaml::parse(File::get($configFile));
            $widget->addTabFields($config);
        });

    }

    public function registerSettings() {
        return [
            'settings' => [
                'label'       => 'martin.birthdays::lang.settings.label',
                'description' => 'martin.birthdays::lang.plugin.description',
                'icon'        => 'icon-birthday-cake',
                'class'       => '\Martin\Birthdays\Models\Settings',
                'order'       => 600,
                'permissions' => ['martin.birthdays.access_settings'],
                'category'    => SettingsManager::CATEGORY_USERS,
            ]
        ];
    }

    public function register() {
        $this->registerConsoleCommand('birthdays.sendmails', 'Martin\Birthdays\Console\SendMails');
    }

    public function registerMailTemplates() {
        return [
            'martin.birthdays::mail.birthday' => Lang::get('martin.birthdays::lang.mails.birthday.description'),
        ];
    }

    public function registerFormWidgets() {
        return [
            'Martin\Birthdays\FormWidgets\Birthday' => 'birthday',
        ];
    }

    public function registerPermissions() {
        return [
            'martin.birthdays.access_settings' => [
                'tab'   => 'rainlab.user::lang.plugin.tab',
                'label' => 'martin.birthdays::lang.permissions.label'
            ],
        ];
    }

}

?>