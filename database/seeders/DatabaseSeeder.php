<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Fine;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Reservation;
use App\Models\Review;
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
        // Reset domain collections for deterministic seed data.
        Fine::query()->delete();
        Review::query()->delete();
        Reservation::query()->delete();
        Loan::query()->delete();
        Book::query()->delete();
        Member::query()->delete();
        Category::query()->delete();

        // 1. Categories
        $categories = [
            ['name' => 'Fiction', 'description' => 'Literary fiction, novels, and stories.'],
            ['name' => 'Science', 'description' => 'Scientific books, technology, and research.'],
            ['name' => 'History', 'description' => 'Historical accounts, biographies, and world events.'],
            ['name' => 'Art', 'description' => 'Design, painting, and artistic theory.'],
            ['name' => 'Cooking', 'description' => 'Recipes, culinary arts, and food history.'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        $allCategories = Category::all();

        // 2. Members
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            Member::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'join_date' => now()->subMonths(rand(1, 12))->toDateString(),
            ]);
        }

        $allMembers = Member::all();

        // 3. Books
        for ($i = 0; $i < 20; $i++) {
            Book::create([
                'title' => $faker->sentence(3),
                'author' => $faker->name,
                'isbn' => $faker->unique()->isbn13,
                'category_id' => $allCategories->random()->id,
                'quantity' => rand(1, 10),
                'status' => 'available',
            ]);
        }

        $allBooks = Book::all();

        // 4. Active Loans
        for ($i = 0; $i < 5; $i++) {
            Loan::create([
                'book_id' => $allBooks->random()->id,
                'member_id' => $allMembers->random()->id,
                'borrow_date' => now()->subDays(rand(1, 15))->toDateString(),
                'due_date' => now()->addDays(rand(5, 15))->toDateString(),
                'status' => 'borrowed',
            ]);
        }

        // 5. Returned Loans (mix: on-time + overdue) and create fines for overdue.
        $dailyFine = (int) config('library.daily_fine', 5000);
        for ($i = 0; $i < 6; $i++) {
            $borrowDate = now()->subDays(rand(20, 50))->toDateString();
            $dueDate = now()->subDays(rand(5, 15))->toDateString();
            $isOverdue = (bool) rand(0, 1);

            $returnDate = $isOverdue
                ? now()->subDays(rand(0, 3))->toDateString()
                : now()->subDays(rand(6, 16))->toDateString();

            $loan = Loan::create([
                'book_id' => $allBooks->random()->id,
                'member_id' => $allMembers->random()->id,
                'borrow_date' => $borrowDate,
                'due_date' => $dueDate,
                'return_date' => $returnDate,
                'status' => 'returned',
            ]);

            if ($isOverdue) {
                $lateDays = max(0, \Carbon\Carbon::parse($dueDate)->diffInDays(\Carbon\Carbon::parse($returnDate), false));
                if ($lateDays > 0) {
                    Fine::create([
                        'loan_id' => $loan->id,
                        'member_id' => $loan->member_id,
                        'amount' => $lateDays * $dailyFine,
                        'reason' => "Overdue {$lateDays} day(s)",
                        'status' => 'unpaid',
                        'issued_at' => $returnDate,
                    ]);
                }
            }
        }

        // 6. Reservations
        for ($i = 0; $i < 8; $i++) {
            Reservation::create([
                'book_id' => $allBooks->random()->id,
                'member_id' => $allMembers->random()->id,
                'status' => collect(['pending', 'approved', 'cancelled'])->random(),
                'request_date' => now()->subDays(rand(1, 20))->toDateString(),
            ]);
        }

        // 7. Reviews
        for ($i = 0; $i < 12; $i++) {
            Review::create([
                'book_id' => $allBooks->random()->id,
                'member_id' => $allMembers->random()->id,
                'rating' => rand(3, 5),
                'comment' => $faker->sentence(10),
            ]);
        }
    }
}
