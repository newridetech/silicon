<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/app')
    ->in(__DIR__.'/bundles')
    ->in(__DIR__.'/config')
    ->in(__DIR__.'/database')
    ->in(__DIR__.'/extensions')
    ->in(__DIR__.'/routes')
    ->in(__DIR__.'/tests')
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        '@Symfony' => true,
        // 'strict_param' => true,
        // 'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder($finder)
;
