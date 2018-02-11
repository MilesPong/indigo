<?php

namespace App\Indigo\FlysystemAdapter;

use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter as BaseGoogleDriveAdapter;
use League\Flysystem\Config;

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
     * Read a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function read($path)
    {
        return $this->callParentMethod($path);
    }

    /**
     * @param $humanPath
     * @param array $args
     * @return array|bool|null
     */
    protected function callParentMethod($humanPath, ...$args)
    {
        $method = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['function'];

        return ($fileId = $this->pathToId($humanPath)) ? parent::{$method}($fileId, ...$args) : false;
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
     * Read a file as a stream.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function readStream($path)
    {
        return $this->callParentMethod($path);
    }

    /**
     * Get all the meta data of a file or directory.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getMetadata($path)
    {
        return $this->callParentMethod($path);
    }

    /**
     * Get the visibility of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getVisibility($path)
    {
        return $this->callParentMethod($path);
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

    /**
     * Write a new file.
     *
     * @param string $path
     * @param string $contents
     * @param Config $config
     *            Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function write($path, $contents, Config $config)
    {
        if ($this->has($path)) {
            // e.g. file_id_1/file_id_2
            return $this->updateContent($path, $contents, $config);
        }

        return $this->createContent($path, $contents, $config);
    }

    /**
     * Check whether a file exists.
     *
     * @param string $path
     *
     * @return array|bool|null
     */
    public function has($path)
    {
        return $this->callParentMethod($path);
    }

    /**
     * @param $humanPath
     * @param $contents
     * @param $config
     * @return array|false
     */
    private function updateContent($humanPath, $contents, $config)
    {
        return parent::write($this->pathToId($humanPath), $contents, $config);
    }

    /**
     * @param $humanPath
     * @param $contents
     * @param $config
     * @return array|false
     */
    private function createContent($humanPath, $contents, $config)
    {
        $path = $this->getNewFilename($humanPath);

        return parent::write($path, $contents, $config);
    }

    /**
     * @param $humanPath
     * @return string
     */
    public function getNewFilename($humanPath): string
    {
        if (($offset = strrpos($humanPath, '/')) !== false) {
            // e.g. file_id_1/foo.txt
            $path = $this->pathToId(substr($humanPath, 0, $offset)) . '/' . substr($humanPath, $offset + 1);
        } else {
            // e.g. foo.txt
            $path = $humanPath;
        }
        return $path;
    }

    /**
     * Rename a file.
     *
     * @param string $from
     * @param string $to
     *
     * @return bool
     */
    public function rename($from, $to)
    {
        return parent::rename($this->pathToId($from), $this->getNewFilename($to));
    }

    /**
     * Copy a file.
     *
     * @param string $from
     * @param string $to
     *
     * @return bool
     */
    public function copy($from, $to)
    {
        return parent::copy($this->pathToId($from), $this->getNewFilename($to));
    }

    /**
     * Delete a file.
     *
     * @param string $humanPath
     *
     * @return bool
     */
    public function delete($humanPath)
    {
        return $this->callParentMethod($humanPath);
    }

    /**
     * Create a directory.
     *
     * @param string $dirname
     *            directory name
     * @param Config $config
     *
     * @return array|false
     */
    public function createDir($dirname, Config $config)
    {
        if ($this->has($dirname)) {
            return false;
        }

        return parent::createDir($this->getNewFilename($dirname), $config);
    }

    /**
     * Set the visibility for a file.
     *
     * @param string $humanPath
     * @param string $visibility
     *
     * @return array|false file meta data
     */
    public function setVisibility($humanPath, $visibility)
    {
        return $this->callParentMethod($humanPath, $visibility);
    }
}
