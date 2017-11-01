<?php

namespace Martin\Birthdays\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateBirthdayLogsTable extends Migration {

    public function up() {

        if (Schema::hasColumn('users', 'birthday_log')) {
            Schema::table('users', function ($table) {
                $table->dropColumn('birthday_log');
            });
        }

        Schema::create('users_birthdays_logs', function ($table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('email');
            $table->string('status');
            $table->integer('year');
            $table->timestamps();
        });

    }

}

?>