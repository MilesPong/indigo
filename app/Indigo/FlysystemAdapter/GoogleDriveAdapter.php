<?php

namespace App\Indigo\FlysystemAdapter;

use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter as BaseGoogleDriveAdapter;

/**
 * Class GoogleDriveAdapter
 * @package App\Indigo\FlysystemAdapter
 */
class GoogleDriveAdapter extends BaseGoogleDriveAdapter
{
    /**
     * List contents of a directory.
     *
     * @param string $dirname
     * @param bool $recursive
     *
     * @return array
     */
    public function listContents($dirname = '', $recursive = false)
    {
        return $this->humanContents(parent::listContents($dirname, $recursive));
    }

    /**
     * @param $listContents
     * @return array
     */
    protected function humanContents($listContents)
    {
        $dirMaps = $this->prepareMaps($listContents);

        return array_map(function ($meta) use ($dirMaps) {
            $pathArray = explode('/', $meta['path']);
            array_pop($pathArray);
            $humanDirArray = [];
            foreach ($pathArray as $fileIdOfDir) {
                array_push($humanDirArray, $dirMaps[$fileIdOfDir]);
            }

            $basename = $this->formatBaseName($meta['filename'], $meta['extension']);
            $meta['path'] = ltrim(implode('/', $humanDirArray) . '/' . $basename, '/');

            return $meta;
        }, $listContents);
    }

    /**
     * @param $listContents
     * @return array
     */
    protected function prepareMaps($listContents)
    {
        $maps = [];

        foreach ($listContents as $meta) {
            if ($meta['type'] != 'dir') {
                continue;
            }

            if ($offset = strrpos($meta['path'], '/')) {
                $fileId = substr($meta['path'], $offset + 1);
            } else {
                $fileId = $meta['path'];
            }

            $maps[$fileId] = $meta['filename'];
        }

        return $maps;
    }

    /**
     * @param $filename
     * @param string $extension
     * @return string
     */
    protected function formatBaseName($filename, $extension = '')
    {
        return rtrim($filename . '.' . $extension, '.');
    }
}