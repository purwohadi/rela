<?php

namespace App\Jobs;

use App\Http\Controllers\CronjobUiController;
use App\Models\Cronjob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ExecuteCronjob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $cronjob;

  /**
   * The number of times the job may be attempted.
   *
   * @var int
   */
  public $tries = 3;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($cronjob)
  {
    $this->cronjob = $cronjob;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    Log::info('percobaan queue', $this->cronjob);
  }
}
