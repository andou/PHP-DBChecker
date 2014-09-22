<?php

/**
 * Drives the application execution
 */
class App {

  /**
   * Actually runs the application
   */
  public static function run() {
    $checker = new Checker();
    Reporter::getInstance()->report($checker->run());
  }

}

