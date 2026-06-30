<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        if (DB::getSchemaBuilder()->hasTable('permission_role')) {
            DB::table('permission_role')->truncate();
        }
        if (DB::getSchemaBuilder()->hasTable('permissions')) {
            DB::table('permissions')->truncate();
        }
        DB::table('roles')->truncate();
        DB::table('users')->truncate();
        DB::table('categories')->truncate();
        DB::table('tags')->truncate();
        DB::table('items')->truncate();

        $this->call([
            RolesSeeder::class,
            AuthorizationSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            ItemSeeder::class,
            ShiftSeeder::class,
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
