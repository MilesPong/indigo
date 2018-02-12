<?php

namespace App\Indigo\FlysystemAdapter;

use Exception;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter as BaseGoogleDriveAdapter;
use League\Flysystem\Config;
use League\Flysystem\FileNotFoundException;

/**
 * Class GoogleDriveAdapter
 * @package App\Indigo\FlysystemAdapter
 */
class GoogleDriveAdapter extends BaseGoogleDriveAdapter
{
    /**
     *
     */
    const TYPE_ALL = 'all';
    /**
     *
     */
    const TYPE_FILE = 'file';
    /**
     *
     */
    const TYPE_DIR = 'dir';
    /**
     * An array to store human_path with file_id.
     *
     * e.g. foo/bar/file => foo_file_id/bar_file_id/file_id
     *
     * @var array
     */
    protected $filePathMap = [];
    /**
     * An array to store human_path with file_id.
     *
     * e.g. foo/bar/file => foo_file_id/bar_file_id
     *
     * @var array
     */
    protected $dirPathMap = [];
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
        return $this->parsePathAndCallParent($path, self::TYPE_FILE);
    }

    /**
     * @param $humanPath
     * @param string $type
     * @param array $args
     * @return array|bool|null
     */
    protected function parsePathAndCallParent($humanPath, $type = self::TYPE_ALL, ...$args)
    {
        $method = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['function'];

        return ($fileId = $this->pathToId($humanPath, $type)) ? parent::{$method}($fileId, ...$args) : false;
    }

    /**
     * @param $humanPath
     * @param string $type
     * @return bool
     */
    public function pathToId($humanPath, $type = self::TYPE_ALL)
    {
        return $this->getPathMap($type)[$humanPath] ?? false;
    }

    /**
     * @param string $type
     * @param bool $force
     * @return array|mixed
     */
    public function getPathMap($type = self::TYPE_ALL, $force = false)
    {
        if (!$this->isPathMapCreated || $force) {
            list($dirPathMap, $filePathMap) = $this->createPathMap();
        } else {
            $dirPathMap = $this->getDirPathMap();
            $filePathMap = $this->getFilePathMap();
        }

        switch ($type) {
            case self::TYPE_ALL:
                return array_merge($dirPathMap, $filePathMap);
            case self::TYPE_FILE:
                return $filePathMap;
            case self::TYPE_DIR:
                return $dirPathMap;
        }

        return [];
    }

    /**
     * @return mixed
     */
    protected function createPathMap()
    {
        $listContents = $this->retrieveAllListContents();

        $dirMap = $this->generateDirMap($listContents);

        $dirPathMap = [];
        $filePathMap = [];

        foreach ($listContents as $meta) {
            $pathArray = explode('/', $meta['path']);
            array_pop($pathArray);
            $humanDirArray = [];
            foreach ($pathArray as $fileIdOfDir) {
                array_push($humanDirArray, $dirMap[$fileIdOfDir]);
            }

            $basename = $this->formatBaseName($meta['filename'], $meta['extension']);
            $humanPath = ltrim(implode('/', $humanDirArray) . '/' . $basename, '/');

            if ($meta['type'] == self::TYPE_FILE) {
                $filePathMap[$humanPath] = $meta['path'];
            } else {
                $dirPathMap[$humanPath] = $meta['path'];
            }
        }

        return tap([$dirPathMap, $filePathMap], function () use ($dirPathMap, $filePathMap) {
            $this->setDirPathMap($dirPathMap);
            $this->setFilePathMap($filePathMap);
            $this->pathMapCreated();
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
     * @param array $data
     */
    private function setDirPathMap(array $data)
    {
        $this->dirPathMap = $data;
    }

    /**
     * @param array $data
     */
    private function setFilePathMap(array $data)
    {
        $this->filePathMap = $data;
    }

    /**
     * @param bool $status
     */
    protected function pathMapCreated($status = true)
    {
        $this->isPathMapCreated = $status;
    }

    /**
     * @return array
     */
    public function getDirPathMap(): array
    {
        return $this->dirPathMap;
    }

    /**
     * @return array
     */
    public function getFilePathMap(): array
    {
        return $this->filePathMap;
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
        return $this->parsePathAndCallParent($path, self::TYPE_FILE);
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
        return $this->parsePathAndCallParent($path);
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
        return $this->parsePathAndCallParent($path);
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
     * @throws \Exception
     */
    public function write($path, $contents, Config $config)
    {
        // Since there no distinction between file and dir, so must check type
        // before write or update a file.
        if ($this->existsDir($path)) {
            throw new Exception("$path is a directory");
        }

        if ($this->existsFile($path)) {
            // e.g. file_id_1/file_id_2
            return $this->updateContent($path, $contents, $config);
        }

        return $this->createContent($path, $contents, $config);
    }

    /**
     * @param $humanPath
     * @return bool
     */
    private function existsDir($humanPath)
    {
        return array_key_exists($humanPath, $this->getDirPathMap());
    }

    /**
     * @param $humanPath
     * @return bool
     */
    private function existsFile($humanPath)
    {
        return array_key_exists($humanPath, $this->getFilePathMap());
    }

    /**
     * @param $humanPath
     * @param $contents
     * @param $config
     * @return array|false
     */
    private function updateContent($humanPath, $contents, $config)
    {
        return parent::write($this->pathToId($humanPath, self::TYPE_FILE), $contents, $config);
    }

    /**
     * @param $humanPath
     * @param $contents
     * @param $config
     * @return array|false
     * @throws \Exception
     */
    private function createContent($humanPath, $contents, $config)
    {
        $path = $this->getNewFilename($humanPath);

        return parent::write($path, $contents, $config);
    }

    /**
     * @param $humanPath
     * @return string
     * @throws \Exception
     */
    public function getNewFilename($humanPath): string
    {
        if (($offset = strrpos($humanPath, '/')) !== false) {
            $dirPath = substr($humanPath, 0, $offset);
            if (!$dirId = $this->pathToId($dirPath, self::TYPE_DIR)) {
                // TODO foo_exists/bar_not_exists/file will be not created.
                throw new Exception("Directory {$dirPath} is not existing, please create it at first.");
            }
            // e.g. file_id_1/foo.txt
            $path = $dirId . '/' . substr($humanPath, $offset + 1);
        } else {
            // e.g. foo.txt
            $path = $humanPath;
        }
        return $path;
    }

    /**
     * Check whether a file or a directory exists.
     *
     * @param string $path
     *
     * @param string $type
     * @return array|bool|null
     */
    public function has($path, $type = self::TYPE_ALL)
    {
        return $this->parsePathAndCallParent($path, $type);
    }

    /**
     * Rename a file.
     *
     * @param string $from
     * @param string $to
     *
     * @return bool
     * @throws \Exception
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
     * @throws \Exception
     */
    public function copy($from, $to)
    {
        return parent::copy($this->pathToId($from), $this->getNewFilename($to));
    }

    /**
     * Delete a directory.
     *
     * @param string $dirname
     *
     * @return bool
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function deleteDir($dirname)
    {
        return $this->delete($dirname, self::TYPE_DIR);
    }

    /**
     * Delete a file (or a directory).
     *
     * @param string $humanPath
     * @param string $type
     * @return bool
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function delete($humanPath, $type = self::TYPE_FILE)
    {
        $this->assertPresent($humanPath, $type);

        return $this->parsePathAndCallParent($humanPath, $type);
    }

    /**
     * @param $humanPath
     * @param $type
     * @return void
     * @throws \League\Flysystem\FileNotFoundException
     */
    protected function assertPresent($humanPath, $type)
    {
        if ((($type == self::TYPE_FILE) && !$this->existsFile($humanPath))
            || (($type == self::TYPE_DIR) && !$this->existsDir($humanPath))) {
            throw new FileNotFoundException($humanPath);
        }
    }

    /**
     * Create a directory.
     *
     * @param string $dirname
     *            directory name
     * @param Config $config
     *
     * @return array|false
     * @throws \Exception
     */
    public function createDir($dirname, Config $config)
    {
        // Since there no distinction between file and dir, we prevent from
        // creating the same name of dir(file) by default.
        if ($this->existsDir($dirname) || $this->existsFile($dirname)) {
            return false;
        }

        // TODO create parent dir recursively, maybe google api is supported?
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
        return $this->parsePathAndCallParent($humanPath, self::TYPE_ALL, $visibility);
    }
}
