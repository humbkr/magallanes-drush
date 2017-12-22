<?php

namespace MageDrush\Task;

use Mage\Task\AbstractTask;

/**
 * Abstract Task for Drupal Drush.
 *
 * This task is responsible for building the drush call, ie the "drush" +
 * alias, preceded by a change directory if necessary.
 *
 * The following options can be set at any level in the .mage.yml file:
 *   - alias: the drush alias to use (optional)
 *   - drupal_root: the drupal root folder on the server> Warning, don't forget
 *     to take releases folders into account if you use them (optional)
 *  Example: drush: {alias: 'mysite' }
 */
abstract class DrushAbstractTask extends AbstractTask
{
  /**
   * Gets options for the global, then the env, then the single task levels, and
   * merge them.
   *
   * @return array
   *   Options to use for the command.
   */
  protected function getOptions()
  {
    $options = array_merge(
      $this->runtime->getMergedOption('drush'),
      $this->options
    );

    return $options;
  }

  /**
   * Builds the drush call for the command.
   *
   * You then just have to concatenate the drush command you want to run,
   * and the possible options.
   *
   * @return string
   *   The drush call for the command.
   */
  protected function buildDrushCall()
  {
    $options = $this->getOptions();
    $cmd = '';

    if (array_key_exists('drupal_root', $options)) {
      $cmd .= sprintf('cd %s; drush ', $options['drupal_root']);
    }
    else {
      $cmd .= sprintf('drush ');
    }

    if (array_key_exists('alias', $options)) {
      $cmd .= sprintf('@%s ', $options['alias']);
    }

    return $cmd;
  }

}
