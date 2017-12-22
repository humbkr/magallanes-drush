<?php

namespace MageDrush\Task;

use Symfony\Component\Process\Process;

/**
 * Runs a features revert (d7).
 *
 * Options:
 *   - features: list of features to revert, separated by a space.
 *
 * If no argument specified, runs a drush fra -y
 */
class DrushCacheRebuildTask extends DrushAbstractTask {
  public function getName()
  {
    return 'drush/features-revert';
  }

  public function getDescription()
  {
    return '[Drush] Run drush features revert';
  }

  public function execute()
  {
    // Get options from the command level.
    if (array_key_exists('features', $this->options)) {
      $cmd = $this->buildDrushCall() . 'fr ' . $this->options['caches'] . ' -y';
    }
    else {
      $cmd = $this->buildDrushCall() . 'fra -y';
    }

    /** @var Process $process */
    $process = $this->runtime->runCommand(trim($cmd));

    return $process->isSuccessful();
  }

}
