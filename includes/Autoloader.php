<?php

/**
 * This class is accountable of classes autoloading
 */
class Autoloader {

  /**
   * Registers autoloading methods
   */
  public function register() {
    spl_autoload_register(array($this, 'autoload_core'));
    spl_autoload_register(array($this, 'autoload_checks'));
  }

  /**
   * Generic loading by filename
   * 
   * @param string $_fl
   */
  protected function _autoload($_fl) {
    if (file_exists($_fl)) {
      include_once $_fl;
    }
  }

  /**
   * Autoloads core classes
   * 
   * @param string $classname
   */
  public function autoload_core($classname) {
    $this->_autoload('includes/core/' . $classname . '.php');
  }

  /**
   * Autoloads check classes
   * 
   * @param string $classname
   */
  public function autoload_checks($classname) {
    $this->_autoload('includes/checks/' . $classname . '.php');
  }

}
