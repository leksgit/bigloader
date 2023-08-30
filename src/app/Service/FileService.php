<?php

namespace App\Service;

use App\Enums\StatusUploadsEnum;
use App\Http\Requests\UploadFileRequest;
use App\Jobs\ProcessCSV;
use App\Models\ErrorRecord;
use App\Models\FileUpload;
use App\Models\GoodRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FileService
{
    public function uploadFileFromRequest(UploadFileRequest $fileRequest): int
    {
        // Store the file in the "uploads" disk (can be local, s3, etc.)
        $path = $fileRequest->file("file")->store("uploads");

        return $this->uploadFile($path);
    }

    public function uploadFile(string $file_path): int
    {
        // Create a new record in the database
        $file = FileUpload::create([
            "file_path" => $file_path,
            "status" => StatusUploadsEnum::pending(),
        ]);
        ProcessCSV::dispatch($file->id);
        return $file->id;
    }

    public function checkStatusById(int $id): array
    {
        $fileUpload = FileUpload::find($id);
        return match ($fileUpload->status) {
            StatusUploadsEnum::completed()->value => ["message" => "Done! Success:" . $fileUpload->success_count . " Error:" . $fileUpload->error_count, "is_done" => true],
            StatusUploadsEnum::error()->value => ["message" => "error upload", "is_done" => true],
            StatusUploadsEnum::pending()->value => ["message" => "in progress", "is_done" => false],
            StatusUploadsEnum::processing()->value => ["message" => "in progress", "is_done" => false],
        };
    }

    public function parseCSV(int $fileUploadId): void
    {
        $fileUpload = FileUpload::find($fileUploadId);
        try {
            $fileUpload->update(["status" => StatusUploadsEnum::processing()->value]);

            DB::beginTransaction();

            $handle = fopen(storage_path("app/" . $fileUpload->file_path), "r");

            if (!$handle) {
                throw new \Exception("Failed to open the CSV file.");
            }

            $good = 0;
            $error = 0;
            while ($row = fgetcsv($handle)) {
                $validator = Validator::make($row, [
                    "*" => "alpha",
                ]);

                if ($validator->fails()) {
                    ErrorRecord::create([
                        "values" => $row,
                        "upload_id" => $fileUpload->id
                    ]);
                    $error++;
                } else {
                    GoodRecord::create([
                        "values" => $row,
                        "upload_id" => $fileUpload->id
                    ]);
                    $good++;
                }
            }

            fclose($handle);
            $fileUpload->update([
                "status" => StatusUploadsEnum::processing()->value,
                "success_count" => $good,
                "error_count" => $error,
            ]);
            DB::commit();
        } catch (\Exception $exception) {
            $fileUpload->update(["status" => StatusUploadsEnum::error()->value]);
            DB::rollBack();
            logs()->error($exception);
        }
    }
}
