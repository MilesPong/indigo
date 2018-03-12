<?php

namespace Indigo\Contracts;

/**
 * Interface Counter
 * @package App\Indigo\Contracts
 */
interface Counter
{
    /**
     * @param \Indigo\Contracts\Viewable $viewable
     * @param int $value
     * @return int|bool
     */
    public function increment(Viewable $viewable, $value = 1);

    /**
     * @param \Indigo\Contracts\Viewable $viewable
     * @return int
     */
    public function get(Viewable $viewable);

    /**
     * @param \Indigo\Contracts\Viewable $viewable
     * @param $value
     * @return mixed
     */
    public function put(Viewable $viewable, $value);

    /**
     * @param \Indigo\Contracts\Viewable|string $viewable
     * @return mixed
     */
    public function getAll($viewable);

    /**
     * @param \Indigo\Contracts\Viewable $viewable
     */
    public function reset(Viewable $viewable);

    /**
     * @param \Indigo\Contracts\Viewable|string $viewable
     * @return bool
     */
    public function resetAll($viewable);
}