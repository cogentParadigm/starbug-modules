<?php
namespace Starbug\Modules;

class Configuration {

  protected $modules;

  public function __construct($modules = []) {
    $this->modules = $modules;
  }

  public function enable($module) {
    $this->modules[$module]["enabled"] = true;
  }

  public function disable($module) {
    $this->modules[$module]["enabled"] = false;
  }

  public function enableAll($criteria = []) {
    foreach ($this->findAll($criteria) as $module) {
      $this->enable($module);
    }
  }

  public function disableAll($criteria = []) {
    foreach ($this->findAll($criteria) as $module) {
      $this->disable($module);
    }
  }

  public function getEnabled() {
    return array_filter($this->modules, function ($module) {
      return $module["enabled"] ?? false;
    });
  }

  public function getModules() {
    return $this->modules;
  }

  public function get($module, $property = false) {
    if (false == $property) {
      return $this->modules[$module];
    }
    return $this->modules[$module][$property];
  }

  protected function findAll($criteria) {
    foreach ($this->modules as $name => $module) {
      if (array_intersect_assoc($criteria, $module) == $criteria) {
        yield $name;
      }
    }
  }
}
