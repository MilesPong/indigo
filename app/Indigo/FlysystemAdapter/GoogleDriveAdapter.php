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
     * A multidimensional array to store human_path with file_id.
     * e.g.
     * [
     *  root => [
     *   foo/bar/file => foo_file_id/bar_file_id/file_id
     *  ]
     * ]
     *
     * @var array
     */
    protected $pathMap = [];
    /**
     * A multidimensional array to store list contents.
     *
     * @var array
     */
    protected $contents = [];

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
        return $this->getPathMap('', true)[$humanPath] ?? false;
    }

    /**
     * @param string $dirname
     * @param bool $recursive
     * @return mixed
     */
    public function getPathMap($dirname = '', $recursive = false)
    {
        return $this->pathMap[$this->formatDirname($dirname)] ?? $this->createPathMap($dirname, $recursive);
    }

    /**
     * @param $dirname
     * @return string
     */
    public function formatDirname($dirname)
    {
        return $dirname ?: 'default';
    }

    /**
     * @param string $dirname
     * @param bool $recursive
     * @return mixed
     */
    private function createPathMap($dirname = '', $recursive = false)
    {
        $this->initializePathMap($dirname);

        $listContents = $this->retrieveListsContents($dirname, $recursive);

        $dirMap = $this->prepareMap($listContents);

        foreach ($listContents as $meta) {
            $pathArray = explode('/', $meta['path']);
            array_pop($pathArray);
            $humanDirArray = [];
            foreach ($pathArray as $fileIdOfDir) {
                array_push($humanDirArray, $dirMap[$fileIdOfDir]);
            }

            $basename = $this->formatBaseName($meta['filename'], $meta['extension']);
            $humanPath = ltrim(implode('/', $humanDirArray) . '/' . $basename, '/');

            $this->setPathMap($dirname, $humanPath, $meta['path']);
        }

        return $this->getPathMap($dirname);
    }

    /**
     * @param $dirname
     */
    private function initializePathMap($dirname)
    {
        $this->pathMap[$this->formatDirname($dirname)] = [];
    }

    /**
     * @param string $dirname
     * @param bool $recursive
     * @return mixed
     */
    public function retrieveListsContents($dirname = '', $recursive = false)
    {
        return $this->contents[$this->formatDirname($dirname)] ?? tap($this->originListContents($dirname, $recursive),
                function ($data) use ($dirname) {
                    $this->setListContents($dirname, $data);
                });
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
     * @param $dirname
     * @param $data
     */
    private function setListContents($dirname, $data)
    {
        $this->contents[$this->formatDirname($dirname)] = $data;
    }

    /**
     * @param $listContents
     * @return array
     */
    private function prepareMap($listContents)
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
     * @param $dirname
     * @param $humanPath
     * @param $fileId
     */
    private function setPathMap($dirname, $humanPath, $fileId)
    {
        $this->pathMap[$this->formatDirname($dirname)][$humanPath] = $fileId;
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
        return $this->humanContents($dirname, $recursive);
    }

    /**
     * @param string $dirname
     * @param bool $recursive
     * @return array
     */
    public function humanContents($dirname = '', $recursive = false)
    {
        $listContents = $this->retrieveListsContents($dirname, $recursive);

        $reversedPathMap = array_flip($this->getPathMap($dirname, $recursive));

        return array_map(function ($meta) use ($reversedPathMap) {
            $meta['path'] = $reversedPathMap[$meta['path']];

            return $meta;
        }, $listContents);
    }
}