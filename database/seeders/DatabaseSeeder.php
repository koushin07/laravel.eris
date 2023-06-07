<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Container\Container;
use Faker\Generator;
use Database\Seeders\RoleSeeder;
use Database\Seeders\ReturnedSeeder;
use Database\Seeders\EquipmentOWnedSeeder;
use Database\Seeders\EquipmentDetailSeeder;
use Database\Seeders\EquipmentAttributeSeeder;
use Database\Seeders\ApprovalSeeder;
use App\Models\Role;
use App\Models\Office;
use App\Models\EquipmentOwned;
use App\Models\EquipmentDetail;
use App\Models\EquipmentAttribute;
use App\Models\Equipment;
use App\Models\AssignOffice;

class DatabaseSeeder extends Seeder
{

    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // $this->call(RoleSeeder::class);
        // $provinces = array(
        //     'camiguin' => [
        //         'Catarman' => [9.12435874658949, 124.675557898537],
        //         'Guinsiliban' => [9.09642903993579, 124.785061108336],
        //         'Mahinog' => [9.156395473, 124.7874664],
        //         'Mambajao' => [9.245050362, 124.726646],
        //         'Sagay' => [9.105221229, 124.7247818]
        //     ],
        //     'Bukidnon' => [
        //         'Baungon' => [8.313060281, 124.6873351],
        //         'Cabanglasan' => [8.077034541, 125.2990361],
        //         'Damulog' => [7.485338155, 124.9412481],
        //         'Dangcagan' => [7.611604446, 125.0022349],
        //         'Don Carlos' => [7.681023813379106, 124.99512384270803],
        //         'Impasug-Ong' => [8.30239834, 125.0008535],
        //         'Kadingilan' => [7.599834052, 124.9095002],
        //         'Kibawe' => [7.569320416, 124.9854067],
        //         'Kitaokitao' => [7.640230999, 125.0084294],
        //         'Lantapan' => [8.00003329, 125.0207382],
        //         'Libona' => [8.367511329, 124.6864745],
        //         'Malaybalay' => [8.126548416, 125.1274213],
        //         'Malitbog' => [8.533904915, 124.8838126],
        //         'Manolo Fortich' => [8.37185597, 124.8565021],
        //         'Maramag' => [7.780496768, 125.0116252],
        //         'Pangantucan' => [7.829324859, 124.8289291],
        //         'Quezon' => [7.714606524, 125.1722154],
        //         'San Fernando' => [7.917050152, 125.3287636],
        //         'Sumilao' => [8.326088809, 124.977639],
        //         'Talakag' => [8.232552207, 124.6037043],
        //         'Valencia' => [7.903034752, 125.0894051]
        //     ],
        //     'Lanao Del Norte' => [
        //         'Bacolod' => [8.189167422, 124.0242467],
        //         'Baloi' => [8.109256055, 124.2294037],
        //         'Baroy' => [8.02626285, 123.7785441],
        //         'Kapatagan' => [7.899474681, 123.7683798],
        //         'Kauswagan' => [8.189596374, 124.0867084],
        //         'Kolambugan' => [8.085601104, 123.8980437],
        //         'Lala' => [7.964311852, 123.7754513],
        //         'Linamon' => [8.183561758, 124.1635725],
        //         'Magsaysay' => [8.046572021, 123.9434551],
        //         'Maigo' => [8.159895258, 123.9604676],
        //         'Matungao' => [8.134429887, 124.1676327],
        //         'Munai' => [8.07862116, 124.0528027],
        //         'Nunungan' => [7.788378402, 123.9089295],
        //         'Pantao Ragat' => [8.078323657, 124.132846],
        //         'Pantar' => [8.058261944, 124.2649987],
        //         'Poona Piagapo' => [8.136356384, 124.1200824],
        //         'Salvador' => [7.906326739, 123.841626],
        //         'Sapad' => [7.870909223, 123.8129313],
        //         'Sultan Naga Dimaporo' => [7.793241445, 123.764687],
        //         'Tagoloan' => [8.175498791, 124.2698243],
        //         'Tangcal' => [7.996913509, 123.9968754],
        //         'Tubod' => [8.044721354, 123.7897]
        //     ],
        //     'Misamis Occidental' => [
        //         'Aloran' => [8.416144119654293, 123.82097266785125],
        //         'Baliangao' => [8.66029439147963, 123.60293303716983],
        //         'Bonifacio' => [8.052701339925473, 123.61382578134362],
        //         'Calamba' => [8.56078950963135, 123.64400780576152],
        //         'Clarin' => [8.200152623838322, 123.86211469668577],
        //         'Concepcion' => [8.421332481543317, 123.60475078326022],
        //         'Don Victoriano Chiongbian' => [8.247318151716952, 123.56861744086278],
        //         'Jimenez' => [8.33538217308207, 123.84018126785095],
        //         'Lopez_Jaena' => [8.526282591550816, 123.75060798134567],
        //         'Oroquieta' => [8.48567386723216, 123.80813953901638],
        //         'Ozamiz' => [8.151137500890195, 123.85020198319152],
        //         'Panaon' => [8.36550576113419, 123.83822045066216],
        //         'Plaridel' => [8.621735367444177, 123.70984192367548],
        //         'Sapang Dalaga' => [8.542611009682343, 123.56757826785186],
        //         'Sinacaban' => [8.285601433349727, 123.84261783901543],
        //         'Tangub' => [8.061306241959048, 123.75147742552053],
        //         'Tudela' => [8.241466148188001, 123.84749825435657]
        //     ],
        //     'Misamis Oriental' => [
        //         'Alubijid' => [8.570881411117911, 124.47318091387639],
        //         'Balingasag' => [8.742594269003574, 124.77435680648715],
        //         'Balingoan' => [9.004110322753089, 124.85040532552486],
        //         'Binuangan' => [8.922148738663214, 124.7857456745521],
        //         'Claveria' => [8.620957599589877, 124.90629989853512],
        //         'El Salvador' => [8.558668543645254, 124.52686485251054],
        //         'Gingoog' => [8.816461426804523, 125.10360363901789],
        //         'Gitagum' => [8.594193369613, 124.40598004271205],
        //         'Initao' => [8.498565229939835, 124.30410428134576],
        //         'Jasaan' => [8.651641566774916, 124.7557631813462],
        //         'Lagonglong' => [8.806254519671132, 124.78789221018236],
        //         'Laguindingan' => [8.573754167405554, 124.44236528319347],
        //         'Libertad' => [8.563240652465401, 124.35208418319361],
        //         'Lugait' => [8.344020032973939, 124.25958384799932],
        //         'Magsaysay' => [9.020048801420009, 125.18226035066533],
        //         'Manticao' => [8.404175039283011, 124.28826991387548],
        //         'Medina' => [8.911760383419256, 125.02486863504262],
        //         'Naawan' => [8.433781099013249, 124.29021002367465],
        //         'Opol' => [8.521273001927467, 124.57416045435787],
        //         'Salay' => [8.85837261008757, 124.7861790236766],
        //         'Sugbongcogon' => [8.956856353778111, 124.78829653901852],
        //         'Tagoloan' => [8.53963298182018, 124.75380442552257],
        //         // 'Talisayan'=>[],
        //         'Villanueva' => [8.58624380552895, 124.77038329668744],
        //     ]

        // );

        // $assignRdrrmc = AssignOffice::create([
        //     'is_rdrrmc' => true,
        // ]);
        // $admin = Role::where('role_type', 'RDRRMC')->first();


        // $provinceRole = Role::where('role_type', Role::PROVINCE)->first();
        // $muniRole = Role::where('role_type', Role::MUNICIPALITY)->first();
        // Office::create([
        //     'firstname' => 'RDRRMC',
        //     'lastname' => 'RDRRMC',
        //     'middlename' => 'RDRRMC',
        //     'email' => 'RDRRMC' . "@gov.ph",
        //     'password' => bcrypt('RDRRMC'),
        //     'must_reset_password' => false,
        //     'assign' => $assignRdrrmc->id,
        //     'role_id' => $admin->id,
        // ]);


        // foreach ($provinces as $province => $municipalities) {
        //     $provAssign = AssignOffice::create([
        //         'province' => $province,
        //     ]);
        //     Office::create([
        //         'firstname' => $this->faker->firstName(),
        //         'lastname' => $this->faker->lastName(),
        //         'middlename' => $this->faker->lastName(),
        //         'suffix' => $this->faker->suffix(),
        //         'address' => $this->faker->address(),
        //         'contact' => $this->faker->phoneNumber(),
        //         'email' => $province . "@gov.ph",
        //         'password' => bcrypt($province),
        //         'must_reset_password' => false,
        //         'assign' => $provAssign->id,
        //         'role_id' => $provinceRole->id,
        //     ]);
        //     foreach ($municipalities as $municipality => $coordinate) {
        //         $count = 1;
        //         $assign =  AssignOffice::create([
        //             'municipality' => $municipality,
        //             'province' => $province,
        //             'latitude' => $coordinate[0],
        //             'longitude' => $coordinate[1]
        //         ]);
        //         $email = Office::where('email', $municipality . '@gov.ph')->first();
        //         if ($email) {
        //             Office::create([
        //                 'firstname' => $this->faker->firstName(),
        //                 'lastname' => $this->faker->lastName(),
        //                 'middlename' => $this->faker->lastName(),
        //                 'suffix' => $this->faker->suffix(),
        //                 'address' => $this->faker->address(),
        //                 'contact' => $this->faker->phoneNumber(),
        //                 'must_reset_password' => false,
        //                 'email' => $municipality . "" . $count . "@gov.ph",
        //                 'password' => bcrypt($municipality),
        //                 'assign' => $assign->id,
        //                 'role_id' => $muniRole->id,
        //             ]);
        //             $count++;
        //         } else {
        //             Office::create([
        //                 'firstname' => $this->faker->firstName(),
        //                 'lastname' => $this->faker->lastName(),
        //                 'middlename' => $this->faker->lastName(),
        //                 'suffix' => $this->faker->suffix(),
        //                 'address' => $this->faker->address(),
        //                 'contact' => $this->faker->phoneNumber(),
        //                 'must_reset_password' => false,
        //                 'email' => $municipality . "@gov.ph",
        //                 'password' => bcrypt($municipality),
        //                 'assign' => $assign->id,
        //                 'role_id' => $muniRole->id,
        //             ]);
        //         }
        //     }
        // }

        $this->call(
            [
                // EquipmentAttributeSeeder::class,
                equipmentSeeder::class,

            ]
        );

        // $this->call(
        //     ApprovalSeeder::class
        // );
    }
}
