<?php

if (PHP_VERSION_ID < 50400) {
    file_put_contents('php://stderr', sprintf(
        "Symfony Installer requires PHP 5.4 version or higher and your system has\n".
        "PHP %s version installed.\n\n".
        "To solve this issue, upgrade your PHP installation or install Symfony manually\n".
        "executing the following command:\n\n".
        "composer create-project symfony/framework-standard-edition <project-name> <symfony-version>\n\n",
        PHP_VERSION
    ));

    exit(1);
}

if (extension_loaded('suhosin')) {
    file_put_contents('php://stderr',
        "Symfony Installer is not compatible with the 'suhosin' PHP extension.\n".
        "Disable that extension before running the installer.\n\n".
        "Alternatively, install Symfony manually executing the following command:\n\n".
        "composer create-project symfony/framework-standard-edition <project-name> <symfony-version>\n\n"
    );

    exit(1);
}

require file_exists(__DIR__.'/vendor/autoload.php')
    ? __DIR__.'/vendor/autoload.php'
    : __DIR__.'/../../autoload.php';

$appVersion = '1.5.9';

// Windows uses Path instead of PATH
if (!isset($_SERVER['PATH']) && isset($_SERVER['Path'])) {
    $_SERVER['PATH'] = $_SERVER['Path'];
}

$app = new Workout\Application('Symfony Certification Workout', $appVersion);
$app->add(new Workout\QuizCommand());

$app->setDefaultCommand('train');

$app->run();
