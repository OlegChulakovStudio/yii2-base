<?php
/**
 * Файл класса Configurator
 *
 * @copyright Copyright (c) 2017, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\base\config;

use Yii;
use yii\base\Configurable;

/**
 * Конфигуратор приложения с кешированием файла конфигурации.
 *
 * Пример использования:
 *
 * $config = Configurator::config(
 *      [
 *          '@common/config/main.php',
 *          '@common/config/main-local.php',
 *          '@frontend/config/main.php',
 *          '@frontend/config/main-local.php'
 *      ],
 *      '@common/config/serv.env',
 *      '@app/config/config-cached.json',
 *      86400
 * );
 */
class Configurator implements Configurable
{
    /**
     * @var int Время истечения кэша конфига
     */
    public $expire = 86400;
    /**
     * @var string Путь к файлу кэша
     */
    public $cacheFile = '@app/config/config-cached.json';
    /**
     * @var array Дополнительные зависимости окружения
     */
    public $envDependency = [];

    /**
     * @var array Путь к зависимостям
     */
    protected $configDependency = [];

    /**
     * Формирование конфигурации
     *
     * @param array $files Список конфигурационных файлов
     * @param array|string $env Список файлов, от которых зависит конфигурация
     * @param string $cache Путь до файла с кешем
     * @param integer $expire Время инвалидации кеша
     * @return array
     */
    public static function config(array $files, $env = null, $cache = null, $expire = null)
    {
        $config = [];
        if (!is_null($env)) {
            $config['envDependency'] = (array)$env;
        }
        if (!is_null($cache)) {
            $config['cacheFile'] = $cache;
        }
        if (!is_null($expire)) {
            $config['expire'] = $expire;
        }

        $configurator = new static($files, $config);

        if ($config = $configurator->getCache()) {
            return $config;
        }

        return $configurator->loadConfig();
    }

    /**
     * Конструктор конфигурации
     *
     * @param array $configDependency
     * @param array|string $config
     */
    protected function __construct(array $configDependency, $config = [])
    {
        $this->configDependency = $configDependency;
        if (!empty($config)) {
            if (is_string($config)) {
                $config = ['envDependency' => [$config]];
            }
            Yii::configure($this, $config);
        }
        $this->init();
    }

    /**
     * Подготовка конфигуратора к работе
     */
    public function init()
    {
        $this->configDependency = array_map(['Yii', 'getAlias'], $this->configDependency);
        $this->cacheFile = Yii::getAlias($this->cacheFile);
        if (!empty($this->envDependency)) {
            $this->envDependency = array_map(['Yii', 'getAlias'], $this->envDependency);
        }
    }

    /**
     * Сборка конфигурационного файла
     *
     * @return array
     */
    protected function loadConfig()
    {
        $config = [];
        foreach ($this->configDependency as $file) {
            $config[] = $this->requireConfig($file);
        }
        $config = call_user_func_array(['yii\helpers\ArrayHelper', 'merge'], $config);
        if ($this->expire > 0) {
            $this->setCache($config);
        }
        return $config;
    }

    /**
     * Внедрение файла конфигурации.
     * Выполняется отдельно для защиты от определения переменых в подключаемом файле.
     *
     * @param string $file
     * @return array
     */
    protected function requireConfig($file)
    {
        if (is_file($file)) {
            return require $file;
        }
        return [];
    }

    /**
     * Получить кешированный конфиг
     *
     * @return array|null
     */
    protected function getCache()
    {
        if (is_file($this->cacheFile) && (filemtime($this->cacheFile) + $this->expire) > time()) {
            $cacheConfig = json_decode(file_get_contents($this->cacheFile), true);
            if (!$this->isModifyDependency($cacheConfig['dependency'])) {
                return $cacheConfig['config'];
            }
            @unlink($this->cacheFile);
        }
        return null;
    }

    /**
     * Сохранение кэша
     *
     * @param array $config
     */
    protected function setCache($config)
    {
        if (!YII_DEBUG) {
            file_put_contents($this->cacheFile, json_encode([
                'dependency' => $this->getAllDependency(),
                'config' => $config,
            ]));
        }
    }

    /**
     * Проверка файлов на изменение
     *
     * @param array $dependency
     * @return bool
     */
    protected function isModifyDependency($dependency)
    {
        if (!$this->equalDependency($dependency)) {
            return true;
        }

        $configUpdated = filemtime($this->cacheFile);
        foreach ($dependency as $file) {
            if (!is_file($file) || filemtime($file) > $configUpdated) {
                return true;
            }
        }

        return false;
    }

    /**
     * Сравнение файлов зависимостей
     *
     * @param array $dependency
     * @return bool
     */
    protected function equalDependency($dependency)
    {
        return empty(array_diff($this->getAllDependency(), $dependency));
    }

    /**
     * Сбор всех файловых зависимостей
     *
     * @return array
     */
    protected function getAllDependency()
    {
        return array_merge(
            $this->configDependency, $this->envDependency
        );
    }
}
