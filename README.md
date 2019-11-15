# PHP-библиотека API mapbox
## В разработке

## Установка

Библиотека устанавливается с помощью пакетного менеджера [Composer](https://getcomposer.org).

1. Добавьте библиотеку в файл `composer.json` вашего проекта:

   ```json
   {
        "repositories": [
            {
                "type": "vcs",
                "url": "https://github.com/WladTitow/yandex-market-php-common"
            }
        ],
        "require": {
            "wladtitow/mapbox-php": "dev-master"
        }
    }
   ```

2. Включите автозагрузчик Composer в код проекта:

   ```php
   require __DIR__ . '/vendor/autoload.php';
   ```   

## Пример использования

```php
    use \Mapbox\Models\RequestPoint as Point;
   
    require __DIR__ . '/vendor/autoload.php';
    
    $token = 'тут токен';

    $navigationClient = new \Mapbox\Clients\Navigation\RetrieveMatrixClient('test', $token);

    $matrixRequest = new \Mapbox\Models\Request\RetrieveMatrixRequest();

    $point1 = new Point(array('longitude' => -122.42, 'latitude' => 37.78));
    $point2 = new Point(array('longitude' => -122.45, 'latitude' => 37.91));
    $point3 = new Point(array('longitude' => -122.48, 'latitude' => 37.73));

    $matrixRequest
        ->addRequestPoint($point1)
        ->addRequestPoint($point2)
        ->addRequestPoint($point3);

    $retrieveMatrix = $navigationClient->getRetrieveMatrix($matrixRequest);

    print_r($retrieveMatrix->getCode());
    print_r($retrieveMatrix->getDurations());
    print_r($retrieveMatrix->getDistances());
    print_r($retrieveMatrix->getSources());
    print_r($retrieveMatrix->getDestinations());    
```