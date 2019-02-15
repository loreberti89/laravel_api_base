<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActiveColoumnUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     /**
      * Run the migrations.
      *
      * @return void
      */
     public function up()
     {
         Schema::table('users', function (Blueprint $table) {
           $table->string('username')->after("email")->unique();
          $table->integer('active')->after("username")->default(1);

         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::table('users', function (Blueprint $table) {
             $table->dropColumn(['username','active']);
         });
     }
}
