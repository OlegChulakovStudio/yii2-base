<?php
/**
 * Файл класса SingletonTrait
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\base\traits;

trait SingletonTrait
{
    /**
     * @var static
     */
    protected static $instance;

    /**
     * Инициализация
     *
     * @return static
     */
    public static function instance()
    {
        if (is_null(static::$instance)) {
            static::$instance = \Yii::createObject(static::class);
        }
        return static::$instance;
    }

    /**
     * Установка инстанса модели
     *
     * @param static $instance
     */
    public static function setInstance($instance)
    {
        static::$instance = $instance;
    }

    /**
     * Автозапонимание первого инстанса модели
     */
    public function __construct()
    {
        static::setInstance($this);
    }
}
