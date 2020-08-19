<?php

declare(strict_types=1);

namespace Recruitment\MailTask\Service;

class Router
{
    public $module;
    public $method;

    public function __construct($requestUri = null)
    {
        $this->module = 'Main';

        if (!$requestUri) {
            $requestUri = $_SERVER['REQUEST_URI'];
        }

        $requestUri = trim($requestUri, '/');
        if (empty($requestUri)) {
            $requestUri = 'index';
        }
        $path = explode('/', trim($requestUri, '/'));
        $this->method = end($path);
    }
}
