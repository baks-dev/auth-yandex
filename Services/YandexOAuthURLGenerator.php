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

namespace BaksDev\Auth\Yandex\Services;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\DependencyInjection\Attribute\Target;

/**
 * Генерирует ссылку для перехода на страницу Яндекс OAuth.
 * @see https://yandex.ru/dev/id/doc/ru/codes/code-url?tabs=defaultTabsGroup-jrbbntfw_%25d0%2597%25d0%25b0%25d0%25bf%25d1%2580%25d0%25be%25d1%2581%2520%25d0%25b2%25d1%258b%25d0%25bf%25d0%25be%25d0%25bb%25d0%25bd%25d0%25b5%25d0%25bd%2520%25d1%2583%25d1%2581%25d0%25bf%25d0%25b5%25d1%2588%25d0%25bd%25d0%25be%2CdefaultTabsGroup-mq43soab_%25d0%2597%25d0%25b0%25d0%25bf%25d1%2580%25d0%25be%25d1%2581%2520%25d0%25b2%25d1%258b%25d0%25bf%25d0%25be%25d0%25bb%25d0%25bd%25d0%25b5%25d0%25bd%2520%25d1%2583%25d1%2581%25d0%25bf%25d0%25b5%25d1%2588%25d0%25bd%25d0%25be#token
 */
final readonly class YandexOAuthURLGenerator
{
    public function __construct(
        #[Target('authYandexLogger')] private LoggerInterface $logger,
        #[Autowire(env: 'YANDEX_CLIENT_ID')] private ?string $clientId = null,
    ) {}

    public function authUrl(): string|null
    {
        if(true === empty($this->clientId))
        {
            $this->logger->warning(
                message: 'Не установлена переменная окружения YANDEX_CLIENT_ID',
                context: [self::class.':'.__LINE__,],
            );

            return null;
        }

        return sprintf('https://oauth.yandex.ru/authorize?response_type=code&client_id=%s', $this->clientId);
    }
}