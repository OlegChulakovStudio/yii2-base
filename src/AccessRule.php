<?php
/**
 * Файл класса AccessRule
 *
 * @copyright Copyright (c) 2017, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\base;

/**
 * Объект передачи данных для валидной генерации правил проверка достапа
 */
class AccessRule
{
    /**
     * @var bool Тип проверки доступа
     */
    protected $allow;
    /**
     * @var array Массив протоколов доступа
     */
    protected $verbs;
    /**
     * @var array Массив ролей доступа
     */
    protected $roles;

    /**
     * Создание настроек для контроля уровня доступа
     *
     * @param string|array $verbs
     * @param bool $allow
     * @param string|array $roles
     */
    public function __construct($verbs = '', $allow = true, $roles = '')
    {
        $this->allow = $allow;
        $this->verbs = static::explodeSetting($verbs);
        $this->roles = static::explodeSetting($roles);
    }

    /**
     * Генерация ключа для проверки совместимости правил
     *
     * @return string
     */
    public function getKey()
    {
        $allow = $this->getAllow() ? 'allow' : 'disallow';
        return implode('-', array_filter([
            implode('-', $this->roles), $allow
        ]));
    }

    /**
     * Получение валидного списка протоколов доступа
     *
     * @return array|null
     */
    public function getVerbs()
    {
        return !empty($this->verbs) ? $this->verbs : null;
    }

    /**
     * Получение валидного списка ролей доступа
     *
     * @return array|null
     */
    public function getAccess()
    {
        return !empty($this->roles) ? $this->roles : null;
    }

    /**
     * Получение валидного типа доступа
     *
     * @return bool
     */
    public function getAllow()
    {
        return !!$this->allow;
    }

    /**
     * Преобразование строки настроект в корректный массив
     *
     * @param string|array $string
     * @return array
     */
    public static function explodeSetting($string)
    {
        if (is_array($string)) {
            return array_values($string);
        }
        return array_filter(array_map('trim',
            explode(',', $string)
        ));
    }
}
