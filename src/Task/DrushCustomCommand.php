<?php

namespace MageDrush\Task;

use Symfony\Component\Process\Process;

class DrushCustomCommand extends DrushAbstractTask {
  public function getName()
  {
    return 'drush/update-database';
  }

  public function getDescription()
  {
    return '[Drush] Run drush custom command';
  }

  public function execute()
  {
    // Get options from the command level.
    if (array_key_exists('command', $this->options)) {
      $cmd = $this->buildDrushCall() . $this->options['command'];

      /** @var Process $process */
      $process = $this->runtime->runCommand(trim($cmd));

      return $process->isSuccessful();
    }

    return false;
  }

}
