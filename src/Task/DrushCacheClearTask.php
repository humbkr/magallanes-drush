<?php

namespace MageDrush\Task;

use Symfony\Component\Process\Process;

/**
 * Runs a cache clear (d7).
 *
 * Options:
 *   - caches: list of caches to clear, separated by a space.
 *
 * If no argument specified, runs a drush cc all
 */
class DrushCacheRebuildTask extends DrushAbstractTask {
  public function getName()
  {
    return 'drush/cache-clear';
  }

  public function getDescription()
  {
    return '[Drush] Run drush cc';
  }

  public function execute()
  {
    // Get options from the command level.
    if (array_key_exists('caches', $this->options)) {
      $cmd = $this->buildDrushCall() . 'cc ' . $this->options['caches'];
    }
    else {
      $cmd = $this->buildDrushCall() . 'cc all';
    }

    /** @var Process $process */
    $process = $this->runtime->runCommand(trim($cmd));

    return $process->isSuccessful();
  }

}
