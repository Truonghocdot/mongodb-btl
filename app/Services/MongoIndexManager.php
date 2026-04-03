<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Category;
use App\Models\Fine;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\User;

class MongoIndexManager
{
    /**
     * @return array<int, string>
     */
    public function sync(): array
    {
        $created = [];

        $created[] = $this->create(Book::class, ['isbn' => 1], [
            'name' => 'books_isbn_unique',
            'unique' => true,
        ]);
        $created[] = $this->create(Book::class, ['category_id' => 1], [
            'name' => 'books_category_id_idx',
        ]);
        $created[] = $this->create(Book::class, ['title' => 1, 'author' => 1], [
            'name' => 'books_title_author_idx',
        ]);

        $created[] = $this->create(Category::class, ['name' => 1], [
            'name' => 'categories_name_unique',
            'unique' => true,
        ]);

        $created[] = $this->create(Member::class, ['email' => 1], [
            'name' => 'members_email_unique',
            'unique' => true,
        ]);
        $created[] = $this->create(Member::class, ['phone' => 1], [
            'name' => 'members_phone_idx',
        ]);

        $created[] = $this->create(User::class, ['email' => 1], [
            'name' => 'users_email_unique',
            'unique' => true,
        ]);
        $created[] = $this->create(User::class, ['role' => 1], [
            'name' => 'users_role_idx',
        ]);

        $created[] = $this->create(Order::class, ['order_code' => 1], [
            'name' => 'orders_order_code_unique',
            'unique' => true,
        ]);
        $created[] = $this->create(Order::class, ['customer_id' => 1, 'ordered_at' => -1], [
            'name' => 'orders_customer_ordered_at_idx',
        ]);
        $created[] = $this->create(Order::class, ['status' => 1, 'ordered_at' => -1], [
            'name' => 'orders_status_ordered_at_idx',
        ]);

        $created[] = $this->create(Loan::class, ['member_id' => 1, 'status' => 1], [
            'name' => 'loans_member_status_idx',
        ]);
        $created[] = $this->create(Loan::class, ['status' => 1, 'due_date' => 1], [
            'name' => 'loans_status_due_date_idx',
        ]);
        $created[] = $this->create(Loan::class, ['book_id' => 1, 'status' => 1], [
            'name' => 'loans_book_status_idx',
        ]);

        $created[] = $this->create(Reservation::class, ['member_id' => 1, 'request_date' => -1], [
            'name' => 'reservations_member_request_date_idx',
        ]);
        $created[] = $this->create(Reservation::class, ['status' => 1, 'request_date' => -1], [
            'name' => 'reservations_status_request_date_idx',
        ]);
        $created[] = $this->create(Reservation::class, ['book_id' => 1, 'member_id' => 1, 'status' => 1], [
            'name' => 'reservations_pending_unique',
            'unique' => true,
            'partialFilterExpression' => ['status' => 'pending'],
        ]);

        $created[] = $this->create(Fine::class, ['loan_id' => 1], [
            'name' => 'fines_loan_id_unique',
            'unique' => true,
        ]);
        $created[] = $this->create(Fine::class, ['member_id' => 1, 'status' => 1], [
            'name' => 'fines_member_status_idx',
        ]);
        $created[] = $this->create(Fine::class, ['status' => 1, 'issued_at' => -1], [
            'name' => 'fines_status_issued_at_idx',
        ]);

        $created[] = $this->create(Review::class, ['book_id' => 1, 'created_at' => -1], [
            'name' => 'reviews_book_created_at_idx',
        ]);
        $created[] = $this->create(Review::class, ['member_id' => 1], [
            'name' => 'reviews_member_idx',
        ]);

        return array_values(array_filter($created));
    }

    /**
     * @param class-string<\MongoDB\Laravel\Eloquent\Model> $modelClass
     */
    private function create(string $modelClass, array $keys, array $options): string
    {
        $modelClass::raw(function ($collection) use ($keys, $options) {
            $collection->createIndex($keys, $options);
        });

        return (string) ($options['name'] ?? 'unnamed_index');
    }
}
