<?php

use Illuminate\Database\Seeder;

class ProblemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Attenction!
         * It could be deleted records existed.
         */
        App\Problem::truncate();

        DB::table('problems')->insert([
            'id' => 999, 'title' => 'Dummy',
            'description' => "## IT IS HIDDEN",
            'is_published' => 0
        ]);

        factory('App\Problem', 30)->create();
    }
}
