<?php

namespace Recruitment\MailTask;

use Recruitment\MailTask\Controller\MainController;
use Recruitment\MailTask\Interfaces\Config;
use Recruitment\MailTask\Interfaces\Output;
use Recruitment\MailTask\Service\MailgunMailer;
use Recruitment\MailTask\Service\Router;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class App
{
    protected $config;
    protected $output;
    protected $router;

    public function __construct(Output $output, Config $config)
    {
        $this->output = $output;
        $this->config = $config;
        $this->router = new Router();
    }

    public function run()
    {
        try {
            $mailer = new MailgunMailer(
                $this->config->getSingleValue('Mailgun.domain'),
                $this->config->getSingleValue('Mailgun.fromName').' <'.$this->config->getSingleValue('Mailgun.fromEmail').'>',
                $this->config->getSingleValue('Mailgun.apiKey'),
                $this->config->getSingleValue('Mailgun.apiHostname')
            );

            $loader = new FilesystemLoader(__DIR__.'/View/');
            $twig = new Environment($loader, [
                'cache' => __DIR__.'/../var/twig_cache/',
                'auto_reload' => true,
            ]);

            $class = new MainController($mailer, $twig);
            $action = $this->router->method.'Action';

            if (method_exists($class, $action)) {
                $class->$action();
            } else {
                echo 'Action Not Found';
            }
        } catch (\Exception $e) {
            print_r($e->getMessage());
            $this->output->print('Error occurred: '.$e->getMessage());
        }
    }
}
