<?php

namespace RockOptionsApi;

use ProcessWire\Field;
use ProcessWire\Page;
use ProcessWire\SelectableOptionArray;
use ProcessWire\Wire;

class Api extends Wire
{
  private $page;

  /** @var Field $field */
  private $field;

  /** @var SelectableOptionArray */
  private $options;

  /** @var SelectableOptionArray */
  private $selected;

  public function __construct(Page $page, $field)
  {
    $this->page = $page;
    $this->page->of(false);
    $this->field = $this->wire->fields->get((string)$field);
    $this->options = $this->field->type->getOptions($this->field);
    $this->selected = $page->getUnformatted((string)$field);
  }

  /**
   * Add option to options field
   * Usage:
   * $page->getOptions('yourfield')->add('foo')->save();
   */
  public function add($option, $save = false): self
  {
    $opt = $this->options->get("id|value=$option");
    $this->selected->add($opt);
    if ($save) $this->save();
    return $this;
  }

  /**
   * Remove option from options field
   * Usage:
   * $page->getOptions('yourfield')->remove('bar')->save();
   */
  public function remove($option, $save = false): self
  {
    $opt = $this->options->get("id|value=$option");
    $this->selected->remove($opt);
    if ($save) $this->save();
    return $this;
  }

  /**
   * Save the current field value to the DB
   * By default it will only save the field, not the whole page
   * 
   * Usage:
   * ->save(); // save field value
   * ->save(true); // save the whole page
   */
  public function save($savePage = false): self
  {
    if ($savePage) $this->page->save();
    else $this->page->save($this->field);
    return $this;
  }
}
