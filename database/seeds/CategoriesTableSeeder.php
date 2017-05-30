<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Category::class)->create([
            'name' => 'uncategorized',
            'description' => 'Default category',
            'slug' => 'uncategorized'
        ]);

        factory(\App\Models\Category::class, 15)->create();
    }
}
