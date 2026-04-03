<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Services\MongoIndexManager;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('library:indexes', function (MongoIndexManager $manager) {
    try {
        $indexes = $manager->sync();

        $this->info('MongoDB indexes synchronized successfully.');
        foreach ($indexes as $indexName) {
            $this->line(" - {$indexName}");
        }
    } catch (\Throwable $e) {
        $this->error('Failed to synchronize indexes: '.$e->getMessage());
        return self::FAILURE;
    }

    return self::SUCCESS;
})->purpose('Create/update MongoDB indexes for library domain collections.');
