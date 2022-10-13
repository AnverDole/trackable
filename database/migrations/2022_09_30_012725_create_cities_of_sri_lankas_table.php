<?php

use App\Models\ProvincesOfSriLanka;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesOfSriLankasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities_of_sri_lankas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('provinces_of_sri_lanka_id');
            $table->timestamps();
        });

        $cities = [
            "Akkaraipattu" => "EAS",
            "Ambalangoda" => "SOU",
            "Ampara" => "EAS",
            "Anuradhapura" => "NCE",
            "Badulla" => "UVA",
            "Balangoda" => "SAB",
            "Bandarawela" => "UVA",
            "Batticaloa" => "EAS",
            "Beruwala" => "WES",
            "Boralesgamuwa" => "WES",
            "Chavakachcheri" => "NOR",
            "Chilaw" => "NWE",
            "Colombo" => "WES",
            "Dambulla" => "CEN",
            "Dehiwala" => "WES",
            "Mount Lavinia" => "WES",
            "Embilipitiya" => "SAB",
            "Eravur" => "EAS",
            "Galle" => "SOU",
            "Gampaha" => "WES",
            "Gampola" => "CEN",
            "Hambantota" => "SOU",
            "Haputale" => "UVA",
            "Hatton-Dickoya" => "CEN",
            "Hikkaduwa" => "SOU",
            "Horana" => "WES",
            "Ja-Ela" => "WES",
            "Jaffna" => "NOR",
            "Kadugannawa" => "CEN",
            "Kaduwela" => "WES",
            "Kalmunai" => "EAS",
            "Kalutara" => "WES",
            "Kandy" => "CEN",
            "Kattankudy" => "EAS",
            "Katunayake" => "WES",
            "Kegalle" => "SAB",
            "Kesbewa" => "WES",
            "Kilinochchi" => "NOR",
            "Kinniya" => "EAS",
            "Kolonnawa" => "WES",
            "Kuliyapitiya" => "NWE",
            "Kurunegala" => "NWE",
            "Maharagama" => "WES",
            "Mannar" => "NOR",
            "Matale" => "CEN",
            "Matara" => "SOU",
            "Minuwangoda" => "WES",
            "Moneragala" => "UVA",
            "Moratuwa" => "WES",
            "Mullaitivu" => "NOR",
            "Nawalapitiya" => "CEN",
            "Negombo" => "WES",
            "Nuwara Eliya" => "CEN",
            "Panadura" => "WES",
            "Peliyagoda" => "WES",
            "Point Pedro" => "NOR",
            "Polonnaruwa" => "NCE",
            "Puttalam" => "NWE",
            "Ratnapura" => "SAB",
            "Avissawella" => "WES",
            "Sri Jayawardenepura" => "WES",
            "Tangalle" => "SOU",
            "Thalawakele" => "CEN",
            "Lindula" => "CEN",
            "Trincomalee" => "EAS",
            "Valvettithurai" => "NOR",
            "Vavuniya" => "NOR",
            "Wattala-Mabole" => "WES",
            "Wattegama" => "CEN",
            "Weligama" => "SOU"
        ];

        foreach ($cities as $city => $admin) {
            ProvincesOfSriLanka::where("abbr", $admin)
                ->first()
                ->Cities()
                ->create([
                    'name' => $city,
                    'cities_of_srilanka_id'
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
        Schema::dropIfExists('cities_of_sri_lankas');
    }
}
