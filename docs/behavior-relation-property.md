# Поведение "Свойства реляции"

Поведение позволяет получить доступ к полям реляции из основной модели. 

## Использование

```php
public function behaviors()
{
    return [
        [
            'class' => RelationPropertyBehavior::class,
            'relation' => 'location',
        ],
    ];
}
```

Определяем метод реляции для модели ActiveRecord:

```php
/**
 * @return ActiveQuery
 */
public function getLocation()
{
    return $this->hasOne(UserLocation::class, ['parent_id' => 'id']);
}
```

Обращаемся к свойствам связанной модели:

```php
$model = User::findOne($condition);
echo $model->address;
```
