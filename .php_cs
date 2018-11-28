<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/app')
    ->in(__DIR__.'/bundles')
    ->in(__DIR__.'/config')
    ->in(__DIR__.'/extensions')
    ->in(__DIR__.'/tests')
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'combine_consecutive_issets' => true,
        'combine_consecutive_unsets' => true,
        'compact_nullable_typehint' => true,
        'escape_implicit_backslashes' => true,
        'explicit_indirect_variable' => true,
        'explicit_string_variable' => true,
        'method_chaining_indentation' => true,
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'new_line_for_chained_calls',
        ],
        'no_useless_else' => true,
        'no_useless_return' => true,
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
                'constant',
                'property_static',
                'property_public',
                'property_protected',
                'property_private',
                'method_public_static',
                'construct',
                'destruct',
                'magic',
                'phpunit',
                'method_public',
                'method_protected_static',
                'method_protected',
                'method_private_static',
                'method_private',
            ],
            'sortAlgorithm' => 'alpha',
        ],
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
        ],
        'simplified_null_return' => true,
        'yoda_style' => true,
    ])
    ->setFinder($finder)
;
