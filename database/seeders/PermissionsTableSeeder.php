<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $keys = [
            //'browse_admin',
            //'browse_bread',
            //'browse_database',
            //'browse_media',
            //'browse_compass',
            //'questions',
            //'answers'
        ];

        foreach ($keys as $key) {
            Permission::firstOrCreate([
                'key'        => $key,
                'table_name' => null,
            ]);
        }

        //Permission::generateFor('questions');

        //Permission::generateFor('answers');

        //Permission::generateFor('appointments');

        //Permission::generateFor('orders');
        //Permission::generateFor('menus');

        //Permission::generateFor('roles');

        //Permission::generateFor('users');

        //Permission::generateFor('settings');

        /*Permission::generateFor('questions');

        Permission::generateFor('answers');

        Permission::generateFor('appointments');

        Permission::generateFor('orders');*/

        Permission::create(['key'=>"A1",
            "table_name"=>"A1"
        ]);

        Permission::create(['key'=>"A2",
            "table_name"=>"A2"
        ]);

        Permission::create(['key'=>"A3",
            "table_name"=>"A3"
        ]);

        Permission::create(['key'=>"B1",
            "table_name"=>"B1"
        ]);

        Permission::create(['key'=>"B2",
            "table_name"=>"B2"
        ]);

        Permission::create(['key'=>"B3",
            "table_name"=>"B3"
        ]);

        Permission::create(['key'=>"C1",
            "table_name"=>"C1"
        ]);

        Permission::create(['key'=>"C2",
            "table_name"=>"C2"
        ]);

        Permission::create(['key'=>"C3",
            "table_name"=>"C3"
        ]);

        Permission::create(['key'=>"user",
            "table_name"=>"user"
        ]);

        Permission::create(['key'=>"role",
            "table_name"=>"user"
        ]);





    }
}
