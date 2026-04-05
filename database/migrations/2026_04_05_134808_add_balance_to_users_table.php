<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('users', function ($table) {
        $table->decimal('balance', 10, 2)->default(0)->after('bio'); // or any position
    });
}

public function down()
{
    Schema::table('users', function ($table) {
        $table->dropColumn('balance');
    });
}
};
