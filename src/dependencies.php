<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// Doctrine
$container['em'] = function ($c) {
    $settings = $c->get('settings');
    $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
        $settings['doctrine']['meta']['entity_path'],
        $settings['doctrine']['meta']['auto_generate_proxies'],
        $settings['doctrine']['meta']['proxy_dir'],
        $settings['doctrine']['meta']['cache'],
        false
    );
    return \Doctrine\ORM\EntityManager::create($settings['doctrine']['connection'], $config);
};

$container['auth'] = function ($c) {
    return new \App\Service\AuthService($c);
};

$container['mail'] = function ($c) {
    return new \App\Service\MailService($c);
};

$container['vialis'] = function ($c) {
    return new \App\Service\VialisService($c);
};

$container['imageStore'] = function ($c) {
    $settings = $c->get('settings');
    return new \App\Service\ImageStoreService(
        $settings['imageStoreRootPath'],
        $settings['imageStoreExternalPath'],
        $c->get('em')
    );
};

// Cache disabled, no need because it's only used for mailing, it can take the time it needs
$container['mailView'] = function ($container) {
    $path = 'cli' === php_sapi_name() ? 'src/view/mail/twig' : '../src/view/mail/twig';
    $view = new \Slim\Views\Twig($path, [
        'cache' => false,
        'debug' => true
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    $view->addExtension(new Twig_Extension_Debug());

    return $view;
};