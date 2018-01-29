<?php

namespace App\Http\Controllers\Backend\Traits;

use Illuminate\Http\Response as IlluminateResponse;

/**
 * Trait ApiResponse
 * @package App\Http\Controllers\Backend\Traits
 */
trait ApiResponse
{
    /**
     * @var int
     */
    protected $statusCode = IlluminateResponse::HTTP_OK;

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successCreated($data)
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_CREATED)->respondWith($data);
    }

    /**
     * @param string|array $array
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWith($array = [], $headers = [])
    {
        return response()->json($array, $this->statusCode, $headers);
    }

    /**
     * @param $status
     * @return $this
     */
    protected function setStatusCode($status)
    {
        $this->statusCode = $status;

        return $this;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successDeleted()
    {
        return $this->successNoContent();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successNoContent()
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NO_CONTENT)->respondWith();
    }
}
