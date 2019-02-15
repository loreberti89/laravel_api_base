<?php
namespace  Illuminate\Database\Seeds;
use Illuminate\Database\Seeder;
use App\Models\Role;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = new Role();
        $role_admin->name ="admin";
        $role_admin->description ="admin site";
        $role_admin->save();
        //
        $role_boss = new Role();
        $role_boss->name ="customer";
        $role_boss->description ="boss customer";
        $role_boss->save();

        $role_user = new Role();
        $role_user->name ="user_customer";
        $role_user->description ="user customer role";
        $role_user->save();

    }
}
