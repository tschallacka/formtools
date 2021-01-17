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
        Schema::table('tschallacka_formtools_form_tools_demos', function(Blueprint $table) {
            $table->string('color', 255)->change();
        });
    }

    public function down()
    {
        Schema::table('tschallacka_formtools_form_tools_demos', function(Blueprint $table) {
            $table->string('color', 15)->change();
        });        
    }
}
