<?php

namespace Burst\Mage2Platform\Commands;

use Burst\Mage2Platform\Exec;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Install extends Command
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

    //    die('configure');

    $this
      ->setName('install')
      ->setDescription('Install Magento 2');
  }

  /**
   * Executes the logic and creates the output.
   *
   * @param InputInterface $input
   * @param OutputInterface $output
   */
  protected function execute(InputInterface $input, OutputInterface $output) {

    $this->output = $output;

    $locale = $input->getOption('locale');
    if (is_array($locale)) {
      $locale = implode(' ', $locale);
    }

    $this->output->writeln('Building Magento');

    $this->exec = new Exec($this->output);
    $this->exec->run('bin/magento setup:di:compile');
    $this->exec->run('bin/magento setup:static-content:deploy -f --strategy=compact --exclude-theme=Magento/blank ' . $locale);

    $this->copyWriteDirs();
  }

  /**
   * Copy generated data from mountable directories to temporary folders
   */
  protected function copyWriteDirs() {
    $this->output->writeln("Move read/write directories to temp directory.");
    $this->exec->run('cd app; cp -Rp etc _etc');
    //    $this->exec->run('cd pub; cp -Rp static _static');
    //    $this->exec->run('cp -Rp generated _generated');
  }

}
