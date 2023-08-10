<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->json('permissions')->nullable();
            $table->timestamps();
        });

//        DB::table('roles')->insert([
//            ['name' => 'Admin', 'slug' => 'admin', 'permissions' => json_encode(['manage_users' => true, 'delete_users' => true])],
//            ['name' => 'Manager', 'slug' => 'manager', 'permissions' => json_encode(['manage_users' => true, 'delete_users' => true])],
//            ['name' => 'Regular User', 'slug' => 'user', 'permissions' => json_encode(['update_profile' => true])],
//        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
