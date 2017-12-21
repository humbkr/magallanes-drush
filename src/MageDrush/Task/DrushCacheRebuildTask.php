<?php

namespace MageDrush\Task;

use Symfony\Component\Process\Process;

class DrushCacheRebuildTask extends DrushAbstractTask {
  public function getName()
  {
    return 'drush/cache-rebuild';
  }

  public function getDescription()
  {
    return '[Drush] Run drush cr';
  }

  public function execute()
  {
    $cmd = $this->buildDrushCall() . 'cr';

    /** @var Process $process */
    $process = $this->runtime->runCommand(trim($cmd));

    return $process->isSuccessful();
  }

}
