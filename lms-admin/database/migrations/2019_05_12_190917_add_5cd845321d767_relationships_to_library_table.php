<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5cd845321d767RelationshipsToLibraryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('libraries', function(Blueprint $table) {
            if (!Schema::hasColumn('libraries', 'coursename_id')) {
                $table->integer('coursename_id')->unsigned()->nullable();
                $table->foreign('coursename_id', '303287_5cd8452e7783c')->references('id')->on('courses')->onDelete('cascade');
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
        Schema::table('libraries', function(Blueprint $table) {
            
        });
    }
}
