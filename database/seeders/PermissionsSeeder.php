<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permissions = [
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'orcamento-create',
            'requests-edition',
            'requests-engraving',
            'requests-locate',
            'printers',
            'hotel-create',
            'hotel-list',
            'report-search'
        ];

        foreach ($permissions as $permission) {
            try{
                Permission::create(['name' => $permission]);
            }catch (\Exception $e){
                echo $e->getMessage();
            }
        }
    }
}
