<?php

namespace Burst\Mage2Platform\Commands;

use Burst\Mage2Platform\Exec;
use Burst\Mage2Platform\Platform;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Deploy extends Command
{

  /**
   * @var Exec
   */
  protected $exec;

  /**
   * @var OutputInterface
   */
  protected $output;

  /**
   * @var Platform
   */
  protected $platform;

  protected function configure() {
    $this
      ->setName('deploy')
      ->setDescription('Deploy Magento 2');
  }

  /**
   * Executes the logic and creates the output.
   *
   * @param InputInterface $input
   * @param OutputInterface $output
   */
  protected function execute(InputInterface $input, OutputInterface $output) {

    $this->output = $output;
    $this->output->writeln('Deploying Magento');
    $this->exec = new Exec($this->output);
    $this->platform = new Platform();

    $this->copyWriteDirs();
    $this->writeEnvFile();

    $this->exec->run('bin/magento app:config:import');
    $this->exec->run('bin/magento setup:upgrade --keep-generated');
    $this->exec->run('bin/magento deploy:mode:set production --skip-compilation');
    $this->exec->run('bin/magento c:c');
  }

  /**
   * Get the default domain from the Platform config.
   *
   * @return string
   * @throws \Symfony\Component\Console\Exception\RuntimeException
   */
  protected function getDomain()
  {
    $routes = $this->platform->getRoutes() ?: [];
    $domain = null;
    foreach($routes as $key => $val) {
      if (
        $val['type'] === 'upstream' &&
        $val['upstream'] === 'magento' &&
        strpos($key, 'https://') === 0
      ) {
        $domain = $key;
        break;
      }
    }

    if ($domain === null) {
      throw new RuntimeException('No correct upstream domain found in Platform routes');
    }

    return $domain;
  }

  /**
   * Write the .env file with all platform relationship variables
   */
  protected function writeEnvFile() {
    $this->output->writeln('Writing env.php configuration.');
    $configFileName = 'app/etc/env.php';
    if (is_file('app/etc/env.platform.php')) {
      $config = include 'app/etc/env.platform.php';
    }
    else {
      throw new \RuntimeException('app/etc/env.platform.php not found');
    }

    $platformConfig = $this->platform->getRelationsAsConfig();

    $config['db']['connection']['default']['username'] = $platformConfig['db_user'];
    $config['db']['connection']['default']['host'] = $platformConfig['db_host'];
    $config['db']['connection']['default']['dbname'] = $platformConfig['db_name'];
    $config['db']['connection']['default']['password'] = $platformConfig['db_password'];
    $config['db']['connection']['default']['model'] = 'mysql4';
    $config['db']['connection']['default']['engine'] = 'innodb';
    $config['db']['connection']['default']['initStatements'] = 'SET NAMES utf8;';
    $config['db']['connection']['default']['active'] = '1';

    $config['backend']['frontName'] = $platformConfig['admin_url'];

    if (
      isset(
        $config['cache']['frontend']['default']['backend'],
        $config['cache']['frontend']['default']['backend_options']
      ) &&
      'Cm_Cache_Backend_Redis' === $config['cache']['frontend']['default']['backend']
    ) {
      $this->output->writeln('Updating env.php Redis cache configuration.');
      $config['cache']['frontend']['default']['backend_options']['server'] = $platformConfig['redis_host'];
      $config['cache']['frontend']['default']['backend_options']['port'] = $platformConfig['redis_port'];
    }

    if (
      isset(
        $config['cache']['frontend']['page_cache']['backend'],
        $config['cache']['frontend']['page_cache']['backend_options']
      ) &&
      'Cm_Cache_Backend_Redis' === $config['cache']['frontend']['page_cache']['backend']
    ) {
      $this->output->writeln('Updating env.php Redis page cache configuration.');

      $config['cache']['frontend']['page_cache']['backend_options']['server'] = $platformConfig['redis_host'];
      $config['cache']['frontend']['page_cache']['backend_options']['port'] = $platformConfig['redis_port'];
    }

    $this->output->writeln('Updating secure and unsecure URLs.');
    $config['system']['default']['web']['secure']['base_url'] = $this->getDomain();
    $config['system']['default']['web']['unsecure']['base_url'] = str_replace('https', 'http', $this->getDomain());

    $updatedConfig = '<?php'  . "\n" . 'return ' . var_export($config, true) . ';';
    file_put_contents($configFileName, $updatedConfig);
  }

  /**
   * Copy back the generated write dirs from the build
   */
  protected function copyWriteDirs() {
    $this->output->writeln('Reset read/write directories back.');
    $this->exec->run('cd app; rm -rf etc/*');
    $this->exec->run('cd app; cp -Rp _etc/* etc');

    $this->exec->run('cd pub; rm -rf static/*');
    $this->exec->run('cd pub; cp -Rp _static/* static');

    $this->exec->run('rm -rf generated/*');
    $this->exec->run('cp -Rp _generated/* generated');

    $this->exec->run('mkdir -p var/session');
  }

}