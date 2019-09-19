# Поведение контроля доступа к контроллеру

Поведение контроля доступа к контроллеру `ControllerMapAccessBehavior`.
Обеспечивает контроль за обращением к контроллерам модуля,
обязуя составлять карту допустимых контроллеров модуля.

## Использование

```php
public function behaviors()
{
    $behaviors = parent::behaviors();
    $behaviors['map'] = [
        'class' => ControllerMapAccessBehavior::class,
        'applicationExclude' => true,
    ];
    return $behaviors;
}
```

В классе модуля перечислите список допустимых контроллеров:

```php
public function init()
{
    parent::init();
    $this->controllerMap = [
       'default' => 'common\modules\<moduleID>\controllers\<ControllerName>',
       ...
    ];
}
```

Свойства поведения:

- `applicationExclude` - Разрешить доступ к контроллерам из Application.
- `exceptionClass` - Класс исключения, которое будет выбрасываться, в случае, если доступ к запрашиваемому контроллеру модуля невозможен.
- `exceptionMessage` - Сообщение, которое будет передано в исключение, если доступ к контроллеру модуля невозможен.
