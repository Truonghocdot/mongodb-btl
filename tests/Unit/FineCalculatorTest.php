<?php

namespace Tests\Unit;

use App\Services\FineCalculator;
use PHPUnit\Framework\TestCase;

class FineCalculatorTest extends TestCase
{
    public function test_it_returns_zero_for_on_time_return(): void
    {
        $calculator = new FineCalculator();

        $result = $calculator->calculate('2026-04-10', '2026-04-10', 5000);

        $this->assertSame(0, $result['late_days']);
        $this->assertSame(0, $result['amount']);
    }

    public function test_it_calculates_overdue_amount_correctly(): void
    {
        $calculator = new FineCalculator();

        $result = $calculator->calculate('2026-04-01', '2026-04-04', 5000);

        $this->assertSame(3, $result['late_days']);
        $this->assertSame(15000, $result['amount']);
    }

    public function test_it_never_returns_negative_amount_with_negative_rate(): void
    {
        $calculator = new FineCalculator();

        $result = $calculator->calculate('2026-04-01', '2026-04-04', -1);

        $this->assertSame(3, $result['late_days']);
        $this->assertSame(0, $result['amount']);
    }
}
