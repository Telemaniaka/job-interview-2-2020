<?php

include __DIR__ . '/vendor/autoload.php';

$finder = PhpCsFixer\Finder::create()
    ->in(['src'])
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'no_alternative_syntax' => true,
        'strict_comparison' => true,
        'strict_param' => true,
        'declare_strict_types' => false,
        'yoda_style' => false,
    ])
    ->setFinder($finder)
    ->setUsingCache(false)
    ->setRiskyAllowed(true)
;
