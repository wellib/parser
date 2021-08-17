#E-commerce parser</h1>


Требования
------------

PHP 7.4

Установка
------------

~~~
composer install;

mkdir /web/uploads;
mkdir /web/uploads/cache;
chmod -R 777 web/uploads;
~~~


Конфигурация
-------------

### БД

Отредактируйте `config/db.php` с реальными данными, например:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=parser',
    'username' => 'root',
    'password' => 'password',
    'charset' => 'utf8',
];
```


Команды
------------

~~~
yii init

yii parser {id сайта}
~~~
