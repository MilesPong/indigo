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
     * @var string
     */
    protected $branch;
    /**
     * @var string
     */
    protected $stageOrHostname;
    /**
     * @var string
     */
    protected $npmEnv;

    /**
     * Deployer constructor.
     */
    public function __construct()
    {
        $this->binDep = base_path('deployer/vendor/bin/dep');
        $this->deployerPath = base_path('deployer');

        $this->setUpConfig();
    }

    /**
     *
     */
    protected function setUpConfig()
    {
        $config = config('indigo.deployer');

        $this->branch = $config['branch'];
        $this->stageOrHostname = $config['stage_or_hostname'];
        $this->npmEnv = $config['npm_env'];
    }

    /**
     * @return bool
     */
    public function release()
    {
        if (!$this->validSetUp()) {
            return Log::error('Deployer has not been set up.');
        }

        $command = "cd {$this->deployerPath} && {$this->binDep} deploy {$this->stageOrHostname} --branch={$this->branch} --npm-env={$this->npmEnv} -vvv 2>&1";

        exec($command, $output, $return);

        if ($return !== 0) {
            Log::error(implode(PHP_EOL, $output));
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function validSetUp()
    {
        return file_exists($this->binDep) && file_exists($this->deployerPath);
    }
}
