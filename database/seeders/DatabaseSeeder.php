<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Categories
        $categories = [
            ['name' => 'Fiction', 'description' => 'Literary fiction, novels, and stories.'],
            ['name' => 'Science', 'description' => 'Scientific books, technology, and research.'],
            ['name' => 'History', 'description' => 'Historical accounts, biographies, and world events.'],
            ['name' => 'Art', 'description' => 'Design, painting, and artistic theory.'],
            ['name' => 'Cooking', 'description' => 'Recipes, culinary arts, and food history.'],
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::create($cat);
        }

        $allCategories = \App\Models\Category::all();

        // 2. Members
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            \App\Models\Member::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'join_date' => now()->subMonths(rand(1, 12))->toDateString(),
            ]);
        }

        $allMembers = \App\Models\Member::all();

        // 3. Books
        for ($i = 0; $i < 20; $i++) {
            \App\Models\Book::create([
                'title' => $faker->sentence(3),
                'author' => $faker->name,
                'isbn' => $faker->isbn13,
                'category_id' => $allCategories->random()->id,
                'quantity' => rand(1, 10),
                'status' => 'available',
            ]);
        }

        $allBooks = \App\Models\Book::all();

        // 4. Loans (Random data)
        for ($i = 0; $i < 5; $i++) {
            \App\Models\Loan::create([
                'book_id' => $allBooks->random()->id,
                'member_id' => $allMembers->random()->id,
                'borrow_date' => now()->subDays(rand(1, 15))->toDateString(),
                'due_date' => now()->addDays(rand(5, 15))->toDateString(),
                'status' => 'borrowed',
            ]);
        }
    }
}
