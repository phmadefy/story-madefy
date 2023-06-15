<?php

use App\Models\Company;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class companySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = Company::create([
            'uuid' => Str::uuid(),
            'razao' => 'Made FY',
            'data_expire' => '2099-12-31',
        ]);

        $company->save();

        if (isset($company->uuid) && !empty($company->uuid)) {

            $permission = UserPermission::create([
                'description' => 'administrador',
                'uuid' => Str::uuid(),
                'company_id' => $company->uuid,
                'create_user' => 1,
                'update_user' => 1,
                'delete_user' => 1,
                'create_permission' => 1,
                'update_permission' => 1,
                'delete_permission' => 1
            ]);

            $user = User::create([
                'uuid' => Str::uuid(),
                'nome' => 'Demonstração',
                'email' => 'dev@madefy.com.br',
                'password' => bcrypt("1234"),
                'company_id' => $company->uuid,
                'permission_id' => $permission->uuid
            ]);

            $user->save();
        }
    }
}
