<?php

namespace Burst\Mage2Platform;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Exec {

  /**
   * @var \Symfony\Component\Console\Output\OutputInterface
   */
  private $output;

  /**
   * Process constructor.
   *
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   */
  public function __construct(OutputInterface $output) {
    $this->output = $output;
  }

  /**
   * Run a process command
   * @param $cmd
   */
  public function run($cmd) {
    $this->output->writeln('Executing cmd: ' . $cmd);
    $process = new Process($cmd);
    $process->setTimeout(0);
//    try {
      $process->mustRun(function ($type, $buffer) {
        if ($type !== Process::ERR && !empty(trim($buffer))) {
          $this->output->writeln($buffer);
        }
      });
//    } catch (ProcessFailedException $exception) {
//      $this->output->writeln('[ERROR]:' . $exception->getMessage());
//    }
  }
}