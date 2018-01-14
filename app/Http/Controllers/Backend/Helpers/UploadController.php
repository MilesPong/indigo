<?php

namespace App\Http\Controllers\Backend\Helpers;

use App\Http\Controllers\Backend\BackendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Class UploadController
 * @package App\Http\Controllers\Backend\Helpers
 */
class UploadController extends BackendController
{
    /**
     * @var string
     */
    protected $path = 'images';

    /**
     * @param $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|max:2048'
        ]);

        $uploadedFile = $request->file('image');

        $uploadPath = $uploadedFile->store($this->path);

        return $this->respondWith([
            'basename' => basename($uploadPath),
            'path' => $uploadPath,
            'original_name' => $uploadedFile->getClientOriginalName(),
            'original_ext' => $uploadedFile->getClientOriginalExtension(),
            'mime_type' => $uploadedFile->getClientMimeType(),
            'size' => $uploadedFile->getClientSize(),
            'human_size' => human_filesize($uploadedFile->getClientSize()),
            'url' => Storage::url($uploadPath),
            // 'h_path' => $uploadedFile->path(),
            // 'h_client_ext' => $uploadedFile->clientExtension(),
            // 'h_ext' => $uploadedFile->extension(),
        ]);
    }
}