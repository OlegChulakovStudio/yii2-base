<?php
/**
 * Файл класса ControllerMapAccessBehavior
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\base\behaviors;

use Yii;
use yii\base\Action;
use yii\base\Controller;
use yii\base\ActionFilter;

/**
 * Поведение контроля доступа к контроллеру.
 * Обеспечивает контроль за обращением к контроллерам модуля,
 * обязуя составлять карту допустимых контроллеров модуля.
 */
class ControllerMapAccessBehavior extends ActionFilter
{
    /**
     * @var Controller
     */
    public $owner;

    /**
     * @var bool Разрешение на доступ к контроллера из Application
     */
    public $applicationExclude = false;

    /**
     * @var string класс-исключения,
     * которое будет выбрасываться при невозможности доступа к запрошенному контроллеру модуля
     */
    public $exceptionClass = '\yii\web\NotFoundHttpException';

    /**
     * @var string текст сообщения,
     * которое будет передано в исключение при невозможноси доступа к запрошенному контроллеру модуля
     */
    protected $exceptionMessage;

    /**
     * @inheritdoc
     */
    public function init()
    {
       if (!$this->exceptionMessage) {
           $this->exceptionMessage = Yii::t('yii', 'Page not found.');
       }
    }

    /**
     * Проверка доступа к контроллеру
     *
     * @param Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        // Проверка разрешения на использования контроллера в Application приложения
        if ($this->applicationExclude && $this->owner->module->id == \Yii::$app->id) {
            return true;
        }
        // Проверка разрешения на доступ к контроллера из модуля только через карту
        if (!isset($this->owner->module->controllerMap[$action->controller->id])) {
            throw new $this->exceptionClass($this->exceptionMessage);
        }
        return true;
    }

    /**
     * Устанавливает текст сообщения исключения
     * @param string $message
     */
    public function setExceptionMessage($message)
    {
        $this->exceptionMessage = $message;
    }
}
