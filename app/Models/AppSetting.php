<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    //
    public function up(){
        Schema::create('app_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key');
                $table->string('value');   
                $table->string('label');
                $table->timestamps();
        });
    }
}
