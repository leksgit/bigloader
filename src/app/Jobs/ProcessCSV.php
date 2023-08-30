<?php

namespace App\Jobs;

use App\Service\FileService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCSV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $fileImportId;

    public function __construct(int $fileImportId)
    {
        $this->fileImportId = $fileImportId;
    }

    public function handle(FileService $fileService): void
    {
        $fileService->parseCSV($this->fileImportId);
    }
}
