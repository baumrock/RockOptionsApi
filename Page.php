<?php

namespace ProcessWire;

use RockOptionsApi\Api;

/**
 * Stub file so that your IDE knows about the new methods :)
 * This file will never get loaded by PW but it will get read by your IDE
 */
class Page
{
  public function getOptions(): Api
  {
    return new Api(new Page(), new Field());
  }
}
