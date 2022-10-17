# RockOptionsApi

ProcessWire module for easy manipulation of option-fields via API

```php
$page->getOptions('yourfield')
  ->add('foo')
  ->remove('bar')
  ->save();
```

<img src=img/optionsapi.gif height=200>

## Readonly options field renderer

By default options fields that are set to readonly via the `locked` collapse state only show selected options and hide other available options. That might not be what you want. Here is an alternative that turns this:

<img src=img/write.png>

Into that:

<img src=img/read.png>

Simply call `$form->readonlyOptions('yourfield')` in the ProcessPageEdit::buildForm hook or when using MagicPages in the `editForm()` method:

```php
$wire->addHookAfter("ProcessPageEdit::buildForm", function($event) {
  $form = $event->return;
  $form->readonlyOptions('yourfield');
});
```
