<?php

namespace Martin\Birthdays\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class UserAddBirthdayLog extends Migration {

    public function up() {

        Schema::table('users', function ($table) {
            $table->json('birthday_log')->after('birthday')->nullable();
        });

    }

    public function down() {

        if (Schema::hasColumn('users', 'birthday_log')) {
            Schema::table('users', function ($table) {
                $table->dropColumn('birthday_log');
            });
        }

    }

}

?>