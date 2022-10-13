<?php

use App\Models\ProvincesOfSriLanka;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvincesOfSriLankasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provinces_of_sri_lankas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('abbr');
            $table->timestamps();
        });

        $provinces = [
            "CEN" => "Central Province",
            "EAS" => "Eastern Province",
            "NCE" => "North Central Province",
            "NOR" => "Northern Province",
            "NWE" => "North Western Province",
            "SAB" => "Sabaragamuwa Province",
            "SOU" => "Southern Province",
            "UVA" => "Uva Province",
            "WES" => "Western Province",
        ];

        foreach ($provinces as $abbr => $province) {
            ProvincesOfSriLanka::create([
                'name' => $province,
                'abbr' => $abbr
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provinces_of_sri_lankas');
    }
}
