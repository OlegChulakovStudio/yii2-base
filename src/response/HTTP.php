<?php
/**
 * Файл класса HTTP
 *
 * @copyright Copyright (c) 2017, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\base\response;

class HTTP
{
    /**
     * Информативный статус - Продолжай
     */
    const INFORMATIVE_CONTINUE = 100;
    /**
     * Информативный статус - Переключение протокола
     */
    const INFORMATIVE_SWITCH_PROTOCOL = 101;
    /**
     * Информативный статус - Идет обработка
     */
    const INFORMATIVE_PROCESSING = 102;

    /**
     * Успешный статус - Хорошо
     */
    const SUCCESS_OK = 200;
    /**
     * Успешный статус - Создано
     */
    const SUCCESS_CREATED = 200; // 201
    /**
     * Успешный статус - Принято
     */
    const SUCCESS_ACCEPTED = 200; // 202
    /**
     * Успешный статус - Информация не авторитетна
     */
    const SUCCESS_NON_AUTHORITATIVE = 203;
    /**
     * Успешный статус - Нет содержимого
     */
    const SUCCESS_NO_CONTENT = 200; // 204
    /**
     * Успешный статус - Сбросить содержимое
     */
    const SUCCESS_RESET_CONTENT = 205;
    /**
     * Успешный статус - Частичное содержимое
     */
    const SUCCESS_PARTIAL_CONTENT = 206;
    /**
     * Успешный статус - Многостатусный
     */
    const SUCCESS_MULTI_STATUS = 207;
    /**
     * Успешный статус - Уже сообщалось
     */
    const SUCCESS_ALREADY_REPORTED = 208;
    /**
     * Успешный статус - Использовано IM
     */
    const SUCCESS_IM_USED = 226;

    /**
     * Статус перенаправления - Множество выборов
     */
    const REDIRECTION_MULTIPLE_CHOICES = 300;
    /**
     * Статус перенаправления - Перемещено навсегда
     */
    const REDIRECTION_MOVED_PERMANENTLY = 301;
    /**
     * Статус перенаправления - Перемещено временно
     */
    const REDIRECTION_MOVED_TEMPORARILY = 302;
    /**
     * Статус перенаправления - Найдено
     */
    const REDIRECTION_FOUND = 302;
    /**
     * Статус перенаправления - Смотреть другое
     */
    const REDIRECTION_SEE_OTHER = 303;
    /**
     * Статус перенаправления - Не изменялось
     */
    const REDIRECTION_NOT_MODIFIED = 304;
    /**
     * Статус перенаправления - Использовать прокси
     */
    const REDIRECTION_USE_PROXY = 305;
    /**
     * Статус перенаправления - Не используется (ЗАРЕЗЕРВИРОВАННО)
     */
    const REDIRECTION_ = 306;
    /**
     * Статус перенаправления - Временное перенаправление
     */
    const REDIRECTION_TEMPORARY_REDIRECT = 307;
    /**
     * Статус перенаправления - Постоянное перенаправление
     */
    const REDIRECTION_PERMANENT_REDIRECT = 308;

    /**
     * Ошибки клиента - Неверный запрос
     */
    const CLIENT_BAD_REQUEST = 400;
    /**
     * Ошибки клиента - Не авторизован
     */
    const CLIENT_UNAUTHORIZED = 401;
    /**
     * Ошибки клиента - Необходима оплата
     */
    const CLIENT_PAYMENT_REQUIRED = 402;
    /**
     * Ошибки клиента - Запрещено
     */
    const CLIENT_FORBIDDEN = 403;
    /**
     * Ошибки клиента - Не найдено
     */
    const CLIENT_NOT_FOUND = 404;
    /**
     * Ошибки клиента - Метод не поддерживается
     */
    const CLIENT_METHOD_NOT_ALLOWED = 405;
    /**
     * Ошибки клиента - Неприемлено
     */
    const CLIENT_NOT_ACCEPTABLE = 406;
    /**
     * Ошибки клиента - Необходима аутентификация прокси
     */
    const CLIENT_PROXY_AUTHENTICATION_REQUIRED = 407;
    /**
     * Ошибки клиента - Истекло время ожидания
     */
    const CLIENT_REQUEST_TIMEOUT = 408;
    /**
     * Ошибки клиента - Конфликт
     */
    const CLIENT_CONFLICT = 409;
    /**
     * Ошибки клиента - Удален
     */
    const CLIENT_GONE = 410;
    /**
     * Ошибки клиента - Необходима длина
     */
    const CLIENT_LENGTH_REQUIRED = 411;
    /**
     * Ошибки клиента - Условие ложно
     */
    const CLIENT_PRECONDITION_FAILED = 412;
    /**
     * Ошибки клиента - Полезная нагрузка слишком велика
     */
    const CLIENT_PAYLOAD_TOO_LARGE = 413;
    /**
     * Ошибки клиента - URI слишком длинный
     */
    const CLIENT_URI_TOO_LONG = 414;
    /**
     * Ошибки клиента - Неподдерживаемый тип данных
     */
    const CLIENT_UNSUPPORTED_MEDIA_TYPE = 415;
    /**
     * Ошибки клиента - Диапазон не достижим
     */
    const CLIENT_RANGE_NOT_SATISFIABLE = 416;
    /**
     * Ошибки клиента - Ожидание не удалось
     */
    const CLIENT_EXPECTATION_FAILED = 417;
    /**
     * Ошибки клиента - Я - чайник
     */
    const CLIENT_IM_A_TEAPOT = 418;
    /**
     * Ошибки клиента - Запрос перенаправлен на сервер
     */
    const CLIENT_MISDIRECTION_REQUEST = 421;
    /**
     * Ошибки клиента - Необрабатываемый экземпляр
     */
    const CLIENT_UNPROCESSABLE_ENTITY = 422;
    /**
     * Ошибки клиента - Заблокировано
     */
    const CLIENT_LOCKED = 423;
    /**
     * Ошибки клиента - Невыполненная зависимость
     */
    const CLIENT_FAILED_DEPENDENCY = 424;
    /**
     * Ошибки клиента - Необходимо обновление
     */
    const CLIENT_UPGRADE_REQUIRED = 426;
    /**
     * Ошибки клиента - Необходимо предусловие
     */
    const CLIENT_PRECONDITION_REQUIRED = 428;
    /**
     * Ошибки клиента - Слишком много запросов
     */
    const CLIENT_TOO_MANY_REQUESTS = 429;
    /**
     * Ошибки клиента - Поля заголовка запроса слишком большие
     */
    const CLIENT_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
    /**
     * Ошибки клиента - Закрывает соеденение без передачи заголовков...
     */
    const CLIENT_CLOSE = 444;
    /**
     * Ошибки клиента - Повторить с
     */
    const CLIENT_RETRY_WITH = 449;
    /**
     * Ошибки клиента - Недоступно по юридическим причинам
     */
    const CLIENT_UNAVAILABLE_FOR_LEGAL_REASON = 451;

    /**
     * Серверная ошибка - Внутренняя ошибка сервера
     */
    const SERVER_INTERNAL_ERROR = 500;
    /**
     * Серверная ошибка - Не реализовано
     */
    const SERVER_NOT_IMPLEMENTED = 501;
    /**
     * Серверная ошибка - Ошибочный шлюз
     */
    const SERVER_BAD_GATEWAY = 502;
    /**
     * Серверная ошибка - Сервис недоступен
     */
    const SERVER_SERVICE_UNAVAILABLE = 503;
    /**
     * Серверная ошибка - Шлюз не отвечает
     */
    const SERVER_GATEWAY_TIMEOUT = 504;
    /**
     * Серверная ошибка - Версия HTTP не поддерживается
     */
    const SERVER_HTTP_VERSION_NOT_SUPPORTED = 505;
    /**
     * Серверная ошибка - Вариант тоже проводит согласование
     */
    const SERVER_VARIANT_ALSO_NEGOTIATES = 506;
    /**
     * Серверная ошибка - Переполнение хранилища
     */
    const SERVER_INSUFFICIENT_STORAGE = 507;
    /**
     * Серверная ошибка - Обнаружено бесконечное перенаправление
     */
    const SERVER_LOOP_DETECTED = 508;
    /**
     * Серверная ошибка - Исчерпана пропускная ширина канала
     */
    const SERVER_BANDWIDTH_LIMIT_EXCEEDED = 509;
    /**
     * Серверная ошибка - Не расширено
     */
    const SERVER_NOT_EXTENDED = 510;
    /**
     * Серверная ошибка - Требуется сетевая аутентификация
     */
    const SERVER_NETWORK_AUTHENTICATION_REQUIRED = 511;
    /**
     * Серверная ошибка - Неизвестная ошибка
     */
    const SERVER_UNKNOWN_ERROR = 520;
    /**
     * Серверная ошибка - Веб-сервер не работает
     */
    const SERVER_WEB_SERVER_IS_DOWN = 521;
    /**
     * Серверная ошибка - Соединение не отвечает
     */
    const SERVER_CONNECTION_TIMED_OUT = 522;
    /**
     * Серверная ошибка - Источник недоступен
     */
    const SERVER_ORIGINAL_IS_UNREACHABLE = 523;
    /**
     * Серверная ошибка - Время ожидания истекло
     */
    const SERVER_A_TIMEOUT_OCCURRED = 524;
    /**
     * Серверная ошибка - Квитирование SSL не удалось
     */
    const SERVER_SSL_HANDSHAKE_FAILED = 525;
    /**
     * Серверная ошибка - Недействительный сертификат SSL
     */
    const SERVER_INVALID_SSL_CERTIFICATE = 526;
}
