<?php namespace TheFehr\Lighthouse\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTheFehrLighthouseSchemes extends Migration
{
    public function up()
    {
        Schema::create('thefehr_lighthouse_schemes', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->text('schema')->nullable();
            $table->boolean('published')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('thefehr_lighthouse_schemes');
    }
}
