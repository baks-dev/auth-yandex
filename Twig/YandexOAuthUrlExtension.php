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

namespace BaksDev\Auth\Yandex\Twig;

use BaksDev\Auth\Yandex\Services\YandexOAuthURLGenerator;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * $params - Устанавливает доп. параметры запроса:
 *
 *  [& device_id=<идентификатор устройства>
 *  [& device_name=<имя устройства>
 *  [& redirect_uri=<адрес перенаправления>
 *  [& login_hint=<имя пользователя или электронный адрес>
 *  [& scope=<запрашиваемые необходимые права>
 *  [& optional_scope=<запрашиваемые опциональные права>
 *  [& force_confirm=yes
 *  [& state=<произвольная строка>
 *  [& code_challenge=<преобразованная верcия верификатора code_verifier>
 *  [& code_challenge_method=<метод преобразования>
 */
final class YandexOAuthUrlExtension extends AbstractExtension
{
    public function __construct(
        #[Autowire(env: 'APP_VERSION')] private readonly string $version,
        private readonly YandexOAuthURLGenerator $yandexOAuthURLGenerator
    ) {}

    /**
     * Функция генерирует ссылку для перехода на страницу Яндекс OAuth
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('yandex_oauth_url', [$this, 'url'],
                ['needs_environment' => true, 'is_safe' => ['html']]),

            new TwigFunction('yandex_oauth_url_template', [$this, 'template'],
                ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function url(?Environment $twig = null, ?array $params = null): string
    {
        $url = $this->yandexOAuthURLGenerator->authUrl($params);
        return empty($url) ? "" : $url;
    }

    public function template(Environment $twig, ?array $params = null): string
    {
        $url = $this->yandexOAuthURLGenerator->authUrl($params) ?? '';

        try
        {
            return $twig->render('@Template/auth-yandex/twig/url/template.html.twig', [
                'url' => $url,
                'version' => $this->version,
            ]);
        }
        catch(LoaderError)
        {
            return $twig->render('@auth-yandex/twig/url/template.html.twig', [
                'url' => $url,
                'version' => $this->version,
            ]);
        }
    }
}
