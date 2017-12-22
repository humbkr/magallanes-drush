# magallanes-drush
Drush tasks for Magallanes 3

## Available commands
drush/cache-clear  
drush/cache-rebuild  
drush/config-export  
drush/config-import  
drush/custom  
drush/features-revert  
drush/update-database

## Installation
Install via composer:
```
composer require humbkr/magallanes-drush
```

Then add the provided tasks as custom tasks in .mage.yml to use them:
```
magephp:
    ...
    custom_tasks:
        - 'MageDrush\Task\DrushCacheRebuildTask'
        - 'MageDrush\Tasks\DrushUpdateDatabaseTask'
        ...
```

Notes: 
- list of available classes is available in vendor/humbkr/magallanes-drush/Task
- you can add only the tasks you require in your deployment script


## Use

After adding the tasks you want to use to the list of custom classes, you can
use them in any deployment step, like so:
```
magephp:
    environments:
        prod:
            drush: { alias: mywebsite }
            pre-deploy:
            on-deploy:
            on-release:
                - drush/sqldump { file: '/var/tmp/before-release.sql' }
            post-release:
                - drush/update-database
                - drush/config-import
                - drush/cache-rebuild
            post-deploy:
```

All the drush tasks have the following common parameters:
- alias: the drush alias to use when running the command (optionnal)
- drupal_root: the path to cd into before running the command (optionnal)

To avoid repetition, you can specify theses parameters with the global configuration
item "drush". This item can be set in the global level or for each environment.
 
Global level:
```
magephp:
    ...
    drush: { alias: mywebsite }
    ...
```

Per environment:
```
magephp:
    environments:
        uat:
            ...
            drush: { alias: mywebsite_uat }
            ...
         
        prod:
            ...
            drush: { alias: mywebsite_prod } 
            ...
```

Moreover, each configuration item overrides the parent one, so a global drush
configuration can be set and them overridden on a specific environment or even
on a per-command basis.

Examples:
```
magephp:
    drush: { alias: mywebsite }
    environments:
        uat:
            ...
            # Only UAT env has a different alias for whatever reason.
            drush: { alias: mywebsite_uat }
            ...
        prod:
            ...
            # Will use the global "mywebsite" alias.
            ...
```

```
magephp:
    drush: { alias: mywebsite }
    environments:
        prod:
            pre-deploy:
                # No alias used on the dev machine (note: it would be useful though).
                - drush/config-export { alias: '', drupal_root: 'drupal/web/sites/default' }
            on-deploy:
            on-release:
            post-release:
                - drush/update-database
                - drush/config-import
                - drush/cache-rebuild
            post-deploy:
```

## Documentation

###### drush/cache-clear
Description: (d7) Clear caches  
Drush command: `drush cc <cache(s) name(s)>`  
Options:
  - caches (optional) : list of caches to be cleared (separated by a space). If
    not specified, clear all caches

###### drush/cache-rebuild
Description: (d8) Rebuild caches  
Drush command: `drush cr`

###### drush/config-export
Description: (d8) Export the configuration to the sync folder specified in settings.php  
Drush command: `drush cex -y`

###### drush/config-import
Description: (d8) Import the configuration from the sync folder specified in settings.php  
Drush command: `drush cim -y`

###### drush/custom
Description: Run a specified drush command. Use only if you can't create a proper custom Magallanes task.  
Drush command: `drush <your command>`  
Options:
  - command (mandatory): the drush command to run, without the "drush" part. Ex: "en mymodule"  

###### drush/features-revert
Description: Revert one or several Features  
Drush command: `drush fr <features list> -y` / `drush fra -y`  
Options:
  - features (optional): List of Features to revert, separated by spaces. If not specified, all Features will be reverted.  

###### drush/update-database
Description: Runs database updates  
Drush command: `drush updb -y`

## Contributions
Feel free to submit your pull requests to add new drush commands. Your requests
must be done on branch master.
Rules :
- drush command must be a command that is helping during multiple deployment 
  process
- your command class must inherit from DrushAbstractTask
