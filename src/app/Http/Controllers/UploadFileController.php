<?php

namespace App\Http\Controllers;

use App\Enums\StatusUploadsEnum;
use App\Http\Requests\FileCheckStatusRequest;
use App\Http\Requests\UploadFileRequest;
use App\Models\FileUpload;
use App\Service\FileService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UploadFileController extends Controller
{
    /**
     * Render view for upload file
     * @return View
     */
    public function view(): View
    {
        return view('components.main');
    }
  public function upload(UploadFileRequest $fileRequest, FileService $fileService): array
    {
        return [
            'message' => 'File uploaded successfully!',
            'file_id' => $fileService->uploadFileFromRequest($fileRequest),
        ];
    }
  public function status(FileCheckStatusRequest $fileCheckStatusRequest, FileService $fileService): array
    {
        return $fileService->checkStatusById($fileCheckStatusRequest->id);
    }

}
