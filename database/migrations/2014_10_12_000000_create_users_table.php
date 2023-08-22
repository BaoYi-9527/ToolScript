<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique()->comment("用户名");
            $table->string('password')->comment("密码");
            $table->tinyInteger('gender')->default(0)->comment("性别 0-未知 1-男 2-女");
            $table->tinyInteger('status')->default(1)->comment('1=可用, 0=不可用');
            $table->string('nickname')->nullable()->comment("用户昵称");
            $table->string('avatar')->nullable()->comment("用户头像");
            $table->integer('phone')->unsigned()->unique()->comment("手机号");
            $table->string('email')->unique()->comment("电子邮箱");
            $table->timestamp('email_verified_at')->nullable()->comment("邮箱验证时间");
            $table->rememberToken()->comment("用户token");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
