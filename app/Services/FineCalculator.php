<?php

namespace App\Services;

use Carbon\Carbon;

class FineCalculator
{
    public function calculate(string $dueDate, string $returnDate, int $dailyRate): array
    {
        $due = Carbon::parse($dueDate);
        $returned = Carbon::parse($returnDate);

        $lateDays = (int) max(0, $due->diffInDays($returned, false));
        $amount = (int) ($lateDays * max(0, $dailyRate));

        return [
            'late_days' => $lateDays,
            'amount' => $amount,
        ];
    }
}
