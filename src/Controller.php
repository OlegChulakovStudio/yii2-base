<?php
/**
 * Файл класса Controller
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\base;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use chulakov\base\behaviors\ControllerMapAccessBehavior;

/**
 * Класс базового контроллера
 */
abstract class Controller extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        // Извлечение настроек
        list($verbs, $access) = $this->compileAccess();

        // Добавление поведения авторизации
        $behaviors = [];

        // Добавление фильтра по методу обращения к экшенам
        if ($verbs = $this->verbsBehavior($verbs)) {
            $behaviors['verb'] = $verbs;
        }

        // Добавления фильтра уровня доступа
        if ($access = $this->accessBehavior($access)) {
            $behaviors['access'] = $access;
        }

        // Добавление фильтра доступа из контроллера
        if ($map = $this->controllerMapBehavior()) {
            $behaviors['map'] = $map;
        }

        return $behaviors;
    }

    /**
     * Список правил доступа к экшенам контроллера.
     *
     * @return AccessRule[]
     */
    abstract public function accessRules();

    /**
     * Генерация фильтрации доступа к экшенам.
     *
     * @param string $method Метод доступа к экшену
     * @param boolean $allow Обработка доступа к экшену
     * @param string|array $permission Правило разрешения доступа к экшену
     * @return AccessRule
     */
    protected function createAccess($method = '', $allow = true, $permission = '')
    {
        return new AccessRule($method, $allow, $permission);
    }

    /**
     * Формирование массивов доступа к экшенам контроллера.
     *
     * @return array
     */
    protected function compileAccess()
    {
        $verbs = [];
        $access = [];
        /** @var AccessRule $rule */
        foreach ($this->accessRules() as $action => $rule) {
            if ($verb = $rule->getVerbs()) {
                $verbs[$action] = $verb;
            }
            $accessKey = $rule->getKey();
            if (!isset($access[$accessKey])) {
                $access[$accessKey] = [
                    'actions' => [],
                    'allow' => $rule->getAllow(),
                ];
                if ($roles = $rule->getAccess()) {
                    $access[$accessKey]['roles'] = $roles;
                }
            }
            $access[$accessKey]['actions'][] = $action;
        }
        return [
            $verbs, array_values($access)
        ];
    }

    /**
     * Создание настроек для фильтра доступа по методу обращения к экшену
     *
     * @param array|null $actions
     * @return array|null
     */
    protected function verbsBehavior($actions)
    {
        if (empty($actions)) {
            return null;
        }
        return [
            'class' => VerbFilter::class,
            'actions' => $actions,
        ];
    }

    /**
     * Создание настроек для фильтра по уровню доступа
     *
     * @param array|null $rules
     * @return array|null
     */
    protected function accessBehavior($rules)
    {
        if (empty($rules)) {
            return null;
        }
        return [
            'class' => AccessControl::class,
            'rules' => $rules,
        ];
    }

    /**
     * Создание настроек для фильтра контроля доступа из контроллера
     *
     * @return array
     */
    protected function controllerMapBehavior()
    {
        return [
            'class' => ControllerMapAccessBehavior::class,
        ];
    }
}
