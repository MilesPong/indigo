<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Closure;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Indigo\Contracts\Counter;
use Indigo\Contracts\Viewable;

/**
 * Class SaveCounter
 * @package App\Console\Commands
 */
class SaveCounter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'counter:save {viewable* : The array of Viewable}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save posts view count into database and flush cache';
    /**
     * @var \Indigo\Contracts\Counter
     */
    private $counter;
    /**
     * @var array
     */
    private $viewableMaps = [];

    /**
     * Create a new command instance.
     *
     * @param \Indigo\Contracts\Counter $counter
     */
    public function __construct(Counter $counter)
    {
        parent::__construct();

        $this->counter = $counter;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $viewableArray = $this->argument('viewable');

        // Validate arguments
        $this->validate($viewableArray);

        $this->iterateViewable(function ($viewable) {
            $stats = $this->getStats($viewable);

            $this->updateCount($viewable, (array)$stats);

            $this->resetStats($viewable);
        });
    }

    /**
     * @param $viewableArray
     */
    private function validate($viewableArray)
    {
        foreach ($viewableArray as $className) {
            $instance = resolve($className);
            if (!$instance instanceof Viewable || !$instance instanceof Model) {
                $this->error("{$className} is not implement with " . Viewable::class);
                exit;
            }
            $this->setViewableMaps($className, $instance);
        }
    }

    /**
     * @param $name
     * @param $instance
     * @return $this
     */
    private function setViewableMaps($name, $instance)
    {
        $this->viewableMaps[$name] = $instance;

        return $this;
    }

    /**
     * @param \Closure $callback
     */
    private function iterateViewable(Closure $callback)
    {
        foreach ($this->viewableMaps as $instance) {
            $callback($instance);
        }
    }

    /**
     * @param $key
     * @return mixed
     */
    private function getStats($key)
    {
        return $this->counter->getAll($key);
    }

    /**
     * @param \Indigo\Contracts\Viewable|\Illuminate\Database\Eloquent\Model $viewable
     * @param array $data
     */
    private function updateCount($viewable, array $data = [])
    {
        $tableData = [];

        foreach ($data as $identifier => $increment) {
            $viewable->newQuery()->where($viewable->getKeyName(), $identifier)->increment($viewable->getCountField(),
                $increment);
            array_push($tableData, [$identifier, $increment]);
        }

        $this->success(get_class($viewable), $tableData);
    }

    /**
     * @param $className
     * @param $tableData
     */
    private function success($className, $tableData)
    {
        $this->info("Save count of {$className} successfully at " . Carbon::now()->toDateTimeString());
        $this->table(['ID', 'Increment'], $tableData);
    }

    /**
     * @param $viewable
     * @return bool
     */
    private function resetStats($viewable)
    {
        return $this->counter->resetAll($viewable);
    }
}
