<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5cd842478530bRelationshipsToCoursematerialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coursematerials', function(Blueprint $table) {
            if (!Schema::hasColumn('coursematerials', 'coursename_id')) {
                $table->integer('coursename_id')->unsigned()->nullable();
                $table->foreign('coursename_id', '303285_5cd842440002c')->references('id')->on('courses')->onDelete('cascade');
                }
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coursematerials', function(Blueprint $table) {
            
        });
    }
}
