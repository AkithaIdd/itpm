<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5cd844863ceaaRelationshipsToAssignmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assignments', function(Blueprint $table) {
            if (!Schema::hasColumn('assignments', 'coursename_id')) {
                $table->integer('coursename_id')->unsigned()->nullable();
                $table->foreign('coursename_id', '303286_5cd84482e5251')->references('id')->on('courses')->onDelete('cascade');
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
        Schema::table('assignments', function(Blueprint $table) {
            
        });
    }
}
