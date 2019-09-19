<?php
/**
 * Файл класса OptionsBehavior
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\base\behaviors;

use yii\base\Behavior;
use yii\db\BaseActiveRecord;
use yii\helpers\Json;

/**
 * Поведение автоматизированной обработки динамический сериализованных данных.
 */
class OptionsBehavior extends Behavior
{
    /**
     * @var string Атрибут модели в котором содержатся данные
     */
    public $attribute = 'options';
    /**
     * @var array Разрешенные динамические атрибуты
     */
    public $options = [];

    /**
     * @var array Массив динамических данных
     */
    protected $data = [];

    /**
     * Подписка на события получения из базы, сохранения в базу и перед проверкой валидации
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_VALIDATE => 'encodeOptions',
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'encodeOptions',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'encodeOptions',
            BaseActiveRecord::EVENT_AFTER_REFRESH => 'decodeOptions',
            BaseActiveRecord::EVENT_AFTER_FIND => 'decodeOptions',
        ];
    }

    /**
     * Установка упакованных данных в модель
     */
    public function encodeOptions()
    {
        $this->owner->{$this->attribute} = Json::encode($this->data);
    }

    /**
     * Извлечение упакованных данных из модели
     */
    public function decodeOptions()
    {
        $data = [];
        if (!empty($this->owner->{$this->attribute})) {
            $data = Json::decode($this->owner->{$this->attribute}, true);
        }
        if (empty($this->options)) {
            $this->options = array_keys($data);
        }
        foreach ($data as $name => $value) {
            $this->data[$name] = $value;
        }
    }

    /**
     * Получение списка расширенных полей
     *
     * @return array
     */
    public function properties()
    {
        return $this->options;
    }

    /**
     * Добавление разрешения на расширение списка свойст объекта
     *
     * @param string $option
     */
    public function addProperty($option)
    {
        if (!in_array($option, $this->options)) {
            $this->options[] = $option;
        }
    }

    /**
     * @inheritdoc
     */
    public function canSetProperty($name, $checkVars = true)
    {
        if (in_array($name, $this->options)) {
            return true;
        }
        return parent::canSetProperty($name, $checkVars);
    }

    /**
     * @inheritdoc
     */
    public function canGetProperty($name, $checkVars = true)
    {
        if (in_array($name, $this->options)) {
            return true;
        }
        return parent::canGetProperty($name, $checkVars);
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        if (in_array($name, $this->options)) {
            return array_key_exists($name, $this->data)
                ? $this->data[$name]
                : null;
        }
        return parent::__get($name);
    }

    /**
     * @inheritdoc
     */
    public function __set($name, $value)
    {
        if (in_array($name, $this->options)) {
            if (is_null($value)) {
                unset($this->data[$name]);
            } else {
                $this->data[$name] = $value;
            }
        } else {
            parent::__set($name, $value);
        }
    }

    /**
     * @inheritdoc
     */
    public function __isset($name)
    {
        if (in_array($name, $this->options)) {
            return true;
        }
        return parent::__isset($name);
    }
}
