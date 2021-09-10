<?php

use App\Organizer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user1 = Organizer::where('slug', 'demo1')->first();
        $user1->password_hash = bcrypt('demopass1');
        $user1->save();
        $user2 = Organizer::where('slug', 'demo2')->first();
        $user2->password_hash = bcrypt('demopass2');
        $user2->save();

        // $this->call(UsersTableSeeder::class);
    }
}
