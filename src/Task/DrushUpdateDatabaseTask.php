<?php

namespace MageDrush\Task;

use Symfony\Component\Process\Process;

/**
 * Runs a database update.
 */
class DrushUpdateDatabaseTask extends DrushAbstractTask {
  public function getName()
  {
    return 'drush/update-database';
  }

  public function getDescription()
  {
    return '[Drush] Run drush updb -y';
  }

  public function execute()
  {
    $cmd = $this->buildDrushCall() . 'updb -y';

    /** @var Process $process */
    $process = $this->runtime->runCommand(trim($cmd));

    return $process->isSuccessful();
  }

}
