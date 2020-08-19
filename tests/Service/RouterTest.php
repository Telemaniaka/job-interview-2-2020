<?php

namespace Recruitment\MailTask\Tests\Service;

use PHPUnit\Framework\TestCase;
use Recruitment\MailTask\Service\Router;

class RouterTest extends TestCase
{

    /**
     * @dataProvider dataProviderRoutesTesting
     */
    public function testRouterReturnsCorrectValuePair($requestUri, $expectedValues)
    {
        $router = new Router($requestUri);

        $this->assertEquals($expectedValues, [
            $router->module,
            $router->method,
            ]);
    }

    public function dataProviderRoutesTesting(): array
    {
        return [
            ['/', ['Main', 'index']],
            ['/submit', ['Main', 'submit']],
        ];
    }

}
