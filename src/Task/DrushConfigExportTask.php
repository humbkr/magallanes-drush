<?php

namespace MageDrush\Task;

use Symfony\Component\Process\Process;

/**
 * Runs a configuration export (d8).
 */
class DrushConfigExportTask extends DrushAbstractTask {
  public function getName()
  {
    return 'drush/config-export';
  }

  public function getDescription()
  {
    return '[Drush] Run drush cex -y';
  }

  public function execute()
  {
    $cmd = $this->buildDrushCall() . 'cex -y';

    /** @var Process $process */
    $process = $this->runtime->runCommand(trim($cmd));

    return $process->isSuccessful();
  }

}
