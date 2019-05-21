<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create1557676607CoursematerialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('coursematerials')) {
            Schema::create('coursematerials', function (Blueprint $table) {
                $table->increments('id');
                $table->string('slug')->nullable();
                $table->text('description')->nullable();
                $table->integer('position')->nullable();
                $table->tinyInteger('freelessons')->nullable()->default('0');
                $table->tinyInteger('published')->nullable()->default('0');
                
                $table->timestamps();
                $table->softDeletes();

                $table->index(['deleted_at']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coursematerials');
    }
}
