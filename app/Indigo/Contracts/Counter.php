<?php

namespace App\Indigo\Contracts;

/**
 * Interface Counter
 * @package App\Indigo\Contracts
 */
interface Counter
{
    /**
     * @param \App\Indigo\Contracts\Viewable $viewable
     * @param int $value
     * @return int|bool
     */
    public function increment(Viewable $viewable, $value = 1);

    /**
     * @param \App\Indigo\Contracts\Viewable $viewable
     * @return int
     */
    public function get(Viewable $viewable);

    /**
     * @param \App\Indigo\Contracts\Viewable $viewable
     * @param $value
     * @return mixed
     */
    public function put(Viewable $viewable, $value);

    /**
     * @param \App\Indigo\Contracts\Viewable|string $viewable
     * @return mixed
     */
    public function getAll($viewable);

    /**
     * @param \App\Indigo\Contracts\Viewable $viewable
     */
    public function reset(Viewable $viewable);

    /**
     * @param \App\Indigo\Contracts\Viewable|string $viewable
     * @return bool
     */
    public function resetAll($viewable);
}