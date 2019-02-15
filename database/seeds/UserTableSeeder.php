<?php
namespace  Illuminate\Database\Seeds;
use Illuminate\Database\Seeder;
use App\User;
use App\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //admin, user_customer


        $role_boss = Role::where('name', 'customer')->first();
        $user = new User();
        $user->name = "Lorenzo Berti";
        $user->username = "lorenzo";
        $user->active = 1;
        $user->email = "lore.berti1989@gmail.com";
        $user->password = bcrypt("lorenzo");
        $user->save();
        $user->roles()->attach($role_boss);

        //name, email, username, active, password
    }
}
