<?php

namespace Martin\Birthdays\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class UserAddBirthdayField extends Migration {

    public function up() {

        Schema::table('users', function ($table) {
            $table->date('birthday')->after('surname')->nullable();
        });

    }

    public function down() {

        if (Schema::hasColumn('users', 'birthday')) {
            Schema::table('users', function ($table) {
                $table->dropColumn('birthday');
            });
        }

    }

}

?>