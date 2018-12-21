<?php

namespace Burst\Mage2Platform\Commands;

use Burst\Mage2Platform\Exec;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Build extends Command
{

  /**
   * @var Exec;
   */
  protected $exec;

  /**
   * @var OutputInterface
   */
  protected $output;

  protected function configure() {

    $this
      ->setName('build')
      ->setDescription('Build Magento 2')
      ->addOption(
        'locale',
        NULL,
        InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED,
        'Optional array of locales like nl_NL or en_US'
      );
  }

  /**
   * Executes the logic and creates the output.
   *
   * @param InputInterface $input
   * @param OutputInterface $output
   */
  protected function execute(InputInterface $input, OutputInterface $output) {

    $this->output = $output;
    $this->exec = new Exec($this->output);

    $locale = $input->getOption('locale');
    if (is_array($locale)) {
      $locale = implode(' ', $locale);
    }

    $this->output->writeln('Building Magento');

    $this->output->writeln("Move read/write directories to temp directory.");
    $this->exec->run('cd app; rm -rf etc/env.php');
    $this->exec->run('cd app; rm -rf _etc');
    $this->exec->run('cd app; cp -Rp etc _etc');

    // If
    if (!Deploy::isStaticContentDeployOnDemand()) {
      $this->exec->run('bin/magento setup:di:compile');
      $this->exec->run('bin/magento setup:static-content:deploy -f ' . $locale);

      // Mounted directories are not kept from the build, so copy them to a tmp folder
      $this->exec->run('cd pub; rm -rf _static');
      $this->exec->run('cd pub; shopt -s dotglob; cp -Rp static _static');

      $this->exec->run('rm -rf _generated');
      $this->exec->run('shopt -s dotglob; cp -Rp generated _generated');
    }
  }
}
