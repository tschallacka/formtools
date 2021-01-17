<?php namespace Tschallacka\FormTools\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Tschallacka\FormTools\Traits\ConsoleLoggerTrait;

class CreateFormToolsDemosTable extends Migration
{
    use ConsoleLoggerTrait;
    
    public function up()
    {
        
        Schema::create('tschallacka_formtools_form_tools_demos', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            
            $table->string('name');
            $table->string('options')->nullable();
            $table->text('color')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tschallacka_formtools_form_tools_demos');
    }
}
