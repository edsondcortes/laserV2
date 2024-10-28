<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class FirstUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        try{
            $role = Role::create(['name' => 'Administrador']);
            $role->syncPermissions(Permission::all());
        }catch (\Exception $e){
            echo "Erro ao criar role: ".$e->getMessage()."\n\n";
        }

        try{
            $user = User::create([
                'name' => "Administrador",
                'email' => "admin@cristaisdegramado.com.br",
                'password' => Hash::make('cristais'),
            ]);
            $user->syncRoles('Administrador');
        }catch (\Exception $e){
            echo "Erro ao criar usuário: ".$e->getMessage()."\n\n";
        }


    }
}
