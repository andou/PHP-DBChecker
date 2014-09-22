<?php

/**
 * Drives the application execution
 */
class App {

  /**
   * Actually runs the application
   */
  public static function run($run = TRUE) {
    $checker = new Checker($run);
    Reporter::getInstance()->report($checker->run());
  }

}

