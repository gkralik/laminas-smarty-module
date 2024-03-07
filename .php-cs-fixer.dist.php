<?php
$finder = (new PhpCsFixer\Finder())
    ->in([
        __DIR__ . '/config',
        __DIR__ . '/src',
    ]);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12'          => true,
        '@PHP81Migration' => true,
        'array_syntax'    => ['syntax' => 'short'],
    ])
    ->setUsingCache(true)
    ->setCacheFile(__DIR__ . '/.php-cs-fixer.cache')
    ->setFinder($finder);