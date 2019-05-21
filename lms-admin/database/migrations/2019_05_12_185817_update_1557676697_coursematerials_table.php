<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1557676697CoursematerialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coursematerials', function (Blueprint $table) {
            if(Schema::hasColumn('coursematerials', 'assignments')) {
                $table->dropColumn('assignments');
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
        Schema::table('coursematerials', function (Blueprint $table) {
                        
        });

    }
}
