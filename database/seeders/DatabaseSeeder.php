<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Product::factory(4)
            ->hasVariants(5)
            ->has(Image::factory(3)->sequence(fn ($sequence) => ['featured' => $sequence->index === 0]))
            ->create();

        User::factory()->create([
            'email' => 'test@test.com',
        ]);
    }
}
