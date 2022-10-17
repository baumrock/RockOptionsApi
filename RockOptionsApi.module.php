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
      'version' => '1.0.1',
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
    $this->wire->addHook("InputfieldWrapper::readonlyOptions", $this, "readonlyOptions");
  }

  public function getOptions(HookEvent $event)
  {
    require_once __DIR__ . "/Api.php";
    $api = $this->wire(new Api($event->object, $event->arguments(0)));
    $event->return = $api;
  }

  public function readonlyOptions(HookEvent $event)
  {
    $form = $event->object;
    $f = $form->get($event->arguments(0));
    if (!$f) return;

    $f->collapsed = $event->arguments(1)
      ? Inputfield::collapsedYesLocked
      : Inputfield::collapsedNoLocked;

    $f->addHookAfter('renderValue', function ($event) use ($f) {
      $out = "<ul>";
      foreach ($f->getOptions() as $k => $v) {
        $yes = in_array($k, $f->value);
        $icon = $yes
          ? "<i class='fa fa-check uk-text-center' style='width:20px;'></i>"
          : "<i class='fa fa-times uk-text-center' style='width:20px;'></i>";
        $class = $yes ? " class='uk-text-bold uk-text-success'" : "";
        $out .= "<li$class>$icon $v</li>";
      }
      $out .= "</ul>";
      $event->return = $out;
    });
  }
}
