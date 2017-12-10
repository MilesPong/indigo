<?php

namespace App\Repositories\Eloquent\Traits;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

/**
 * Trait FieldsHandler
 * @package App\Repositories\Eloquent\Traits
 */
trait FieldsHandler
{
    /**
     * @param $value
     * @return Carbon
     */
    public function handlePublishedAt($value)
    {
        if (empty($value)) {
            return Carbon::now();
        }

        return Carbon::createFromTimestamp(strtotime($value));
    }

    /**
     * @param $value
     * @return int
     */
    public function handleIsDraft($value)
    {
        if (empty($value)) {
            return $this->model->getConst('IS_NOT_DRAFT');
        }

        return $this->model->getConst('IS_DRAFT');
    }

    /**
     * @param UploadedFile $file
     * @param string $path
     * @param string $disk
     * @return false|string
     */
    public function handleFeatureImgFile(UploadedFile $file, $path = 'images', $disk = 'public')
    {
        $storePath = $file->store($path, $disk);

        if ($disk == 'public') {
            return asset('storage/' . $storePath);
        }

        return $storePath;
    }

    /**
     * @param array $attributes
     * @return array
     */
    public function handleImg(array $attributes)
    {
        if (array_has($attributes, $img = 'feature_img_file')) {
            array_set($attributes, 'feature_img', array_get($attributes, $img));
        }

        return $attributes;
    }
}