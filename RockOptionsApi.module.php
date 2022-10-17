<?php

namespace ProcessWire;

use RockOptionsApi\Api;

/**
 * @author Bernhard Baumrock, 17.10.2022
 * @license Licensed under MIT
 * @link https://www.baumrock.com
 */
class RockOptionsApi extends WireData implements Module
{

  public static function getModuleInfo()
  {
    return [
      'title' => 'RockOptionsApi',
      'version' => '1.0.0',
      'summary' => 'Module for easy manipulation of option-fields via API',
      'autoload' => true,
      'singular' => true,
      'icon' => 'code',
      'requires' => [
        'PHP>=8.0',
      ],
    ];
  }

  public function init()
  {
    $this->wire->addHook("Page::getOptions", $this, "getOptions");
  }

  public function getOptions(HookEvent $event)
  {
    require_once __DIR__ . "/Api.php";
    $api = $this->wire(new Api($event->object, $event->arguments(0)));
    $event->return = $api;
  }
}
