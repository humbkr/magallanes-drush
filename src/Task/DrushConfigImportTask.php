<?php

namespace MageDrush\Task;

use Symfony\Component\Process\Process;

/**
 * Runs a configuration import (d8).
 */
class DrushConfigImportTask extends DrushAbstractTask {
  public function getName()
  {
    return 'drush/config-import';
  }

  public function getDescription()
  {
    return '[Drush] Run drush cim -y';
  }

  public function execute()
  {
    $cmd = $this->buildDrushCall() . 'cim -y';

    /** @var Process $process */
    $process = $this->runtime->runCommand(trim($cmd));

    return $process->isSuccessful();
  }

}
