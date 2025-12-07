# BaksDev Auth Yandex

[![Version](https://img.shields.io/badge/version-7.3.3-blue)](https://github.com/baks-dev/auth-yandex/releases)
![php 8.4+](https://img.shields.io/badge/php-min%208.4-red.svg)
[![packagist](https://img.shields.io/badge/packagist-green)](https://packagist.org/packages/baks-dev/auth-yandex)

Модуль авторизации пользователя в Yandex

## Установка

``` bash
$ composer require baks-dev/auth-yandex
```

## Дополнительно

Переменные окружения:

```
YANDEX_CLIENT_ID=<you_id>
YANDEX_CLIENT_SECRET=<you_secret>
```

Установка конфигурации и файловых ресурсов:

``` bash
$ php bin/console baks:assets:install
```

Изменения в схеме базы данных с помощью миграции

``` bash
$ php bin/console doctrine:migrations:diff

$ php bin/console doctrine:migrations:migrate
```

## Тестирование

``` bash
$ php bin/phpunit --group=auth-yandex
```

## Лицензия ![License](https://img.shields.io/badge/MIT-green)

The MIT License (MIT). Обратитесь к [Файлу лицензии](LICENSE.md) за дополнительной информацией.

