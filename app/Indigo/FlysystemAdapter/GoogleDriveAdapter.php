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
     * An array to store human_path with file_id.
     *
     * e.g. foo/bar/file => foo_file_id/bar_file_id/file_id
     *
     * @var array
     */
    protected $pathMap = [];
    /**
     * An array to store all list contents.
     *
     * @var array
     */
    protected $contents = [];
    /**
     * Determine if path map is created.
     *
     * @var bool
     */
    protected $isPathMapCreated = false;

    /**
     * Check whether a file exists.
     *
     * @param string $path
     *
     * @return array|bool|null
     */
    public function has($path)
    {
        $path = $this->pathToId($path);

        return $path ? parent::has($path) : false;
    }

    /**
     * @param $humanPath
     * @return bool
     */
    public function pathToId($humanPath)
    {
        return $this->getPathMap()[$humanPath] ?? false;
    }

    /**
     * @param bool $force
     * @return array|mixed
     */
    public function getPathMap($force = false)
    {
        return (!$this->isPathMapCreated || $force) ? tap($this->createPathMap(), function () {
            $this->pathMapCreated();
        }) : $this->pathMap;
    }

    /**
     * @param $data
     * @return $this
     */
    protected function setPathMap($data)
    {
        $this->pathMap = $data;

        return $this;
    }

    /**
     * @return mixed
     */
    protected function createPathMap()
    {
        $listContents = $this->retrieveAllListContents();

        $dirMap = $this->generateDirMap($listContents);

        $data = [];

        foreach ($listContents as $meta) {
            $pathArray = explode('/', $meta['path']);
            array_pop($pathArray);
            $humanDirArray = [];
            foreach ($pathArray as $fileIdOfDir) {
                array_push($humanDirArray, $dirMap[$fileIdOfDir]);
            }

            $basename = $this->formatBaseName($meta['filename'], $meta['extension']);
            $humanPath = ltrim(implode('/', $humanDirArray) . '/' . $basename, '/');

            $data[$humanPath] = $meta['path'];
        }

        return tap($data, function ($data) {
            $this->setPathMap($data);
        });
    }

    /**
     * @return mixed
     */
    public function retrieveAllListContents()
    {
        return $this->contents ?: tap($this->allListContents(), function ($data) {
            $this->setListContents($data);
        });
    }

    /**
     * @return mixed
     */
    public function allListContents()
    {
        return $this->originListContents('', true);
    }

    /**
     * @param string $dirname
     * @param bool $recursive
     * @return mixed
     */
    public function originListContents($dirname = '', $recursive = false)
    {
        return parent::listContents($dirname, $recursive);
    }

    /**
     * @param $data
     */
    protected function setListContents($data)
    {
        $this->contents = $data;
    }

    /**
     * @param $listContents
     * @return array
     */
    private function generateDirMap($listContents)
    {
        $map = [];

        foreach ($listContents as $meta) {
            if ($meta['type'] != 'dir') {
                continue;
            }

            if ($offset = strrpos($meta['path'], '/')) {
                $fileId = substr($meta['path'], $offset + 1);
            } else {
                $fileId = $meta['path'];
            }

            $map[$fileId] = $meta['filename'];
        }

        return $map;
    }

    /**
     * @param $filename
     * @param string $extension
     * @return string
     */
    public function formatBaseName($filename, $extension = '')
    {
        return rtrim($filename . '.' . $extension, '.');
    }

    /**
     * @param bool $status
     */
    protected function pathMapCreated($status = true)
    {
        $this->isPathMapCreated = $status;
    }

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
        return $this->humanListContents($dirname, $recursive);
    }

    /**
     * @param string $directory
     * @param bool $recursive
     * @return array
     */
    public function humanListContents($directory = '', $recursive = false)
    {
        $listContents = $this->filter($this->retrieveAllListContents(), $directory, $recursive);

        $reversedPathMap = array_flip($this->getPathMap());

        return array_map(function ($meta) use ($reversedPathMap) {
            $meta['path'] = $reversedPathMap[$meta['path']];

            return $meta;
        }, $listContents);
    }

    /**
     * @param $contents
     * @param $directory
     * @param bool $recursive
     * @return array
     */
    private function filter($contents, $directory, $recursive = false)
    {
        $directoryLength = strlen($directory);

        $reversedPathMap = array_flip($this->getPathMap());

        return array_filter($contents,
            function ($meta) use ($recursive, $directory, $directoryLength, $reversedPathMap) {
                $humanPath = $reversedPathMap[$meta['path']];

                if ($directoryLength == 0) {
                    // Base 'root' folder
                    return $recursive ? true : (substr_count($humanPath, '/') == 0 ? true : false);
                }

                if (substr($humanPath, 0, $directoryLength) === (string)$directory) {
                    $separatorCount = substr_count(substr($humanPath, $directoryLength), '/');

                    return (!$recursive && ($separatorCount == 1)) || ($recursive && $separatorCount != 0);
                }

                return false;
            });
    }
}
