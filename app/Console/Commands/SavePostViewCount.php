<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Repositories\Contracts\PostRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class SavePostViewCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'view_count:save';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save posts view count into DB and flush cache';

    /**
     * @var mixed
     */
    protected $cacheKeyPrefix;

    /**
     * @var PostRepository
     */
    protected $postRepo;

    /**
     * Create a new command instance.
     *
     * @param PostRepository $postRepo
     * @return void
     */
    public function __construct(PostRepository $postRepo)
    {
        parent::__construct();

        $this->postRepo = $postRepo;

        $this->cacheKeyPrefix = config('blog.counter.cache_key');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = $this->savePostViewCount();

        $this->info("Post view_count save successfully at " . Carbon::now()->toDateTimeString());
        $this->table(['Post ID', 'Increase Count'], $data);
    }

    /**
     * Retrieve all post view_count from cache and save into DB
     *
     * @return array
     */
    protected function savePostViewCount()
    {
        $results = [];

        // Retrieve all post id
        $this->postRepo
            ->getModel()
            ->select('id')
            ->chunk(100, function ($posts) use (&$results) {
                foreach ($posts as $post) {
                    if ($count = $this->getCacheCount($post->id)) {
                        $post->increment('view_count', $count);

                        array_push($results, [$post->id, $count]);

                        $this->flushCache($this->cacheKey($post->id));
                    }
                }
            });

        return $results;
    }

    /**
     * Get post view_count from cache
     *
     * @param $id
     * @return mixed
     */
    protected function getCacheCount($id)
    {
        return Cache::get($this->cacheKey($id));
    }

    /**
     * Get cache key
     *
     * @param $id
     * @return string
     */
    protected function cacheKey($id)
    {
        return $this->cacheKeyPrefix . $id;
    }

    /**
     * Flush post view_count in cache by key
     *
     * @param $key
     * @return bool
     */
    protected function flushCache($key)
    {
        return Cache::forget($key);
    }
}
