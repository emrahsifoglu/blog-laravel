<?php

namespace App\Console\Commands;

use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteOutdatedFeedsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feeds:delete-outdated';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete comments or blog posts older than 3 hours';

    /**
     * @var PostRepository
     */
    protected PostRepository $postRepository;

    /**
     * @var CommentRepository
     */
    protected CommentRepository $commentRepository;

    /**
     * @param PostRepository $postRepository
     * @param CommentRepository $commentRepository
     */
    public function __construct(
      PostRepository $postRepository,
      CommentRepository $commentRepository
    )
    {
      $this->postRepository = $postRepository;
      $this->commentRepository = $commentRepository;
      parent::__construct();
    }

    /**
     * @return int
     */
    public function handle(): int
    {
        $this->postRepository->deleteAllOutDated();
        $this->commentRepository->deleteAllOutDated();
        return 0;
    }
}
