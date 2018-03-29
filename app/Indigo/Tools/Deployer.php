<?php

namespace Indigo\Tools;

use Illuminate\Support\Facades\Log;

/**
 * Class Deployer
 * @package Indigo\Tools
 */
class Deployer
{
    /**
     * @var string
     */
    protected $binDep;
    /**
     * @var string
     */
    protected $deployerPath;

    /**
     * Deployer constructor.
     */
    public function __construct()
    {
        $this->binDep = base_path('deployer/vendor/bin/dep');
        $this->deployerPath = base_path('deployer');
    }

    /**
     * @return bool
     */
    public function release()
    {
        if (!$this->validSetUp()) {
            return Log::error('Deployer has not been set up.');
        }

        $command = "cd {$this->deployerPath} && {$this->binDep} deploy localhost --branch=master --npm-env=prod -vv 2>&1";

        exec($command, $output, $return);

        if ($return !== 0) {
            Log::error(implode("\n", $output));
        }
    }

    /**
     * @return bool
     */
    protected function validSetUp()
    {
        return file_exists($this->binDep) && file_exists($this->deployerPath);
    }
}