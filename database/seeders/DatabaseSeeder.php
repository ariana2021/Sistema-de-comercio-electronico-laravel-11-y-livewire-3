<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(PagesSeeder::class);
        $this->call(AboutUsSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(BusinessSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(RatingSeeder::class);
        $this->call(SliderSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(CommentSeeder::class);
    }
}
