<?php
/*
 *  Copyright 2025.  Baks.dev <admin@baks.dev>
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is furnished
 *  to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in all
 *  copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NON INFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  THE SOFTWARE.
 *
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use BaksDev\Auth\Yandex\BaksDevAuthYandexBundle;
use BaksDev\Auth\Yandex\Type\Event\AccountYandexEventType;
use BaksDev\Auth\Yandex\Type\Event\AccountYandexEventUid;
use BaksDev\Auth\Yandex\Type\YandexUser\AccountYandexUserId;
use BaksDev\Auth\Yandex\Type\YandexUser\AccountYandexUserIdType;
use Symfony\Config\DoctrineConfig;

return static function(ContainerConfigurator $container, DoctrineConfig $doctrine) {

    $services = $container->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    /** Types */
    $doctrine->dbal()->type(AccountYandexEventUid::TYPE)->class(AccountYandexEventType::class);
    $doctrine->dbal()->type(AccountYandexUserId::TYPE)->class(AccountYandexUserIdType::class);

    $emDefault = $doctrine->orm()->entityManager('default')->autoMapping(true);

    $emDefault->mapping('auth-yandex')
        ->type('attribute')
        ->dir(BaksDevAuthYandexBundle::PATH.'Entity')
        ->isBundle(false)
        ->prefix(BaksDevAuthYandexBundle::NAMESPACE.'\\Entity')
        ->alias('auth-yandex');
};
