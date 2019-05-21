<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1557681628CoursematerialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coursematerials', function (Blueprint $table) {
            
if (!Schema::hasColumn('coursematerials', 'title')) {
                $table->string('title');
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
            $table->dropColumn('title');
            
        });

    }
}
