<?php
/**
 * Файл класса BaseMessage
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\base\mail;

use yii\base\Configurable;
use yii\helpers\ArrayHelper;
use yii\mail\MailerInterface;

/**
 * Базовое сообщение для отправки на почту
 */
abstract class BaseMessage implements Configurable
{
    /**
     * @var MailerInterface
     */
    protected $mailer;
    /**
     * @var string Путь до html шаблона
     */
    protected $html;
    /**
     * @var string Путь до текстовой версии шаблона
     */
    protected $text;
    /**
     * @var string Тема сообщения
     */
    protected $subject;

    /**
     * Конструктор сообщения
     *
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
        $this->init();
    }

    /**
     * Инициализация
     */
    public function init() {}

    /**
     * Отправка сообщения
     *
     * @param string|array $email
     * @param array $params
     * @return mixed
     */
    public function send($email, $params = [])
    {
        return $this->compose($email, $params)->send();
    }

    /**
     * Сборка сообщения
     *
     * @param string|array $email
     * @param array $params
     * @return \yii\mail\MessageInterface
     */
    public function compose($email, $params = [])
    {
        // Сбор параметров письма
        $params = array_merge_recursive(
            $this->getExtendedParams(), $params
        );

        // Проверка дополнительных опций сообщения
        $properties = ArrayHelper::remove(
            $params, 'properties'
        );

        // Подготовка сообщения
        $message = $this->mailer
            ->compose([
                'html' => $this->html,
                'text' => $this->text,
            ], $params)
            ->setSubject($this->subject)
            ->setTo($email);

        // Применение дополнительных опций к сообщению
        if (!empty($properties) && is_array($properties)) {
            foreach ($properties as $name => $value) {
                $message->{$name} = $value;
            }
        }

        return $message;
    }

    /**
     * Дополнительные параметры для письма
     *
     * @return array
     */
    protected function getExtendedParams()
    {
        return [];
    }

    /**
     * Создание сообщения для отправки
     *
     * @param array $params
     * @return BaseMessage|object
     * @throws \yii\base\InvalidConfigException
     */
    public static function create($params = [])
    {
        return \Yii::createObject(get_called_class(), $params);
    }
}
