<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('uuid');
            $table->bigInteger('parent_id')->default(NONE);
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('user_name')->unique()->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('verification_code')->nullable();
            $table->foreignId('current_team_id')->nullable();
            $table->text('profile_photo_path')->nullable();

            $table->tinyInteger('type')
                ->default(USER)
                ->comment('0 = User, 1 = Admin');

            $table->tinyInteger('is_super_admin')
                ->default(NO)
                ->comment('0 = No, 1 = Yes');

            $table->tinyInteger('is_online')
                ->default(NO)
                ->comment('0 = No, 1 = Yes');

            $table->tinyInteger('is_active')
                ->default(NO)
                ->comment('0 = No, 1 = Yes');

            $table->bigInteger('added_by')->default(NONE);
            $table->bigInteger('last_updated_by')->default(NONE);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
