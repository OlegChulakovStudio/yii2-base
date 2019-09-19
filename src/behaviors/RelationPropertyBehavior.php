<?php
/**
 * Файл класса RelationPropertyBehavior
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\base\behaviors;

use yii\base\Model;
use yii\base\Behavior;
use yii\base\InvalidConfigException;

/**
 * Поведение доступа к полям реляции из основной модели
 */
class RelationPropertyBehavior extends Behavior
{
    /**
     * @var string|Model
     */
    public $relation;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (empty($this->relation)) {
            throw new InvalidConfigException('Необходимо указать имя реляции.');
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        if ($this->hasRelationProperty($name)) {
            return $this->getRelationProperty($name);
        }
        return parent::__get($name);
    }

    /**
     * @inheritdoc
     */
    public function __set($name, $value)
    {
        if ($this->hasRelationProperty($name)) {
            $this->setRelationProperty($name, $value);
        } else {
            parent::__set($name, $value);
        }
    }

    /**
     * @inheritdoc
     */
    public function canGetProperty($name, $checkVars = true)
    {
        if ($this->hasRelationProperty($name)) {
            return true;
        }
        return parent::canGetProperty($name, $checkVars);
    }

    /**
     * @inheritdoc
     */
    public function canSetProperty($name, $checkVars = true)
    {
        if ($this->hasRelationProperty($name)) {
            return true;
        }
        return parent::canSetProperty($name, $checkVars);
    }

    /**
     * Проверка наличия свойства в реляции
     *
     * @param string $name
     * @return bool
     */
    protected function hasRelationProperty($name)
    {
        if (is_string($this->relation)) {
            $this->relation = $this->owner->{$this->relation};
        }
        return $this->relation->hasProperty($name);
    }

    /**
     * Получение свойства из связанной модели
     *
     * @param string $name
     * @return mixed
     */
    protected function getRelationProperty($name)
    {
        return $this->relation->{$name};
    }

    /**
     * Смена свойства в связанной модели
     *
     * @param string $name
     * @param mixed $value
     */
    protected function setRelationProperty($name, $value)
    {
        $this->relation->{$name} = $value;
    }
}
