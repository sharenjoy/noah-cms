<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CharifyCountriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('countries.table_name'), function ($table) {
            DB::statement("ALTER TABLE " . DB::getTablePrefix() . config('countries.table_name') . " MODIFY country_code CHAR(3) NOT NULL DEFAULT ''");
            DB::statement("ALTER TABLE " . DB::getTablePrefix() . config('countries.table_name') . " MODIFY iso_3166_2 CHAR(2) NOT NULL DEFAULT ''");
            DB::statement("ALTER TABLE " . DB::getTablePrefix() . config('countries.table_name') . " MODIFY iso_3166_3 CHAR(3) NOT NULL DEFAULT ''");
            DB::statement("ALTER TABLE " . DB::getTablePrefix() . config('countries.table_name') . " MODIFY region_code CHAR(3) NOT NULL DEFAULT ''");
            DB::statement("ALTER TABLE " . DB::getTablePrefix() . config('countries.table_name') . " MODIFY sub_region_code CHAR(3) NOT NULL DEFAULT ''");
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('countries.table_name'), function ($table) {
            DB::statement("ALTER TABLE " . DB::getTablePrefix() . config('countries.table_name') . " MODIFY country_code VARCHAR(3) NOT NULL DEFAULT ''");
            DB::statement("ALTER TABLE " . DB::getTablePrefix() . config('countries.table_name') . " MODIFY iso_3166_2 VARCHAR(2) NOT NULL DEFAULT ''");
            DB::statement("ALTER TABLE " . DB::getTablePrefix() . config('countries.table_name') . " MODIFY iso_3166_3 VARCHAR(3) NOT NULL DEFAULT ''");
            DB::statement("ALTER TABLE " . DB::getTablePrefix() . config('countries.table_name') . " MODIFY region_code VARCHAR(3) NOT NULL DEFAULT ''");
            DB::statement("ALTER TABLE " . DB::getTablePrefix() . config('countries.table_name') . " MODIFY sub_region_code VARCHAR(3) NOT NULL DEFAULT ''");
        });
    }
}
