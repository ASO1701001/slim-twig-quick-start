<?php
use Application\Controller\IndexController;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Factory\AppFactory;
use Slim\Psr7\Response;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\Error\LoaderError;
use Twig\Extension\DebugExtension;

require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../src/function.php";

session_start();

$app = AppFactory::create();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$errorMiddleware->setErrorHandler(
    HttpForbiddenException::class,
    function (ServerRequestInterface $request) {
        $response = new Response();
        $response = $response->withStatus(403);
        $response->getBody()->write("403 Forbidden.");
        return $response;
    }
);
$errorMiddleware->setErrorHandler(
    HttpNotFoundException::class,
    function (ServerRequestInterface $request) {
        $response = new Response();
        $response = $response->withStatus(404);
        $response->getBody()->write("404 Not Found.");
        return $response;
    }
);
$errorMiddleware->setErrorHandler(
    HttpMethodNotAllowedException::class,
    function (ServerRequestInterface $request) {
        $response = new Response();
        $response = $response->withStatus(405);
        $response->getBody()->write("405 Method Not Allowed.");
        return $response;
    }
);

try {
    $twig = Twig::create(__DIR__ . "/../view", [
        "debug" => true,
        "cache" => __DIR__ . "/../cache"
    ]);
    $twig->addExtension(new DebugExtension());
    $app->add(TwigMiddleware::create($app, $twig));

    $app->get("/", IndexController::class.":get");

    $app->run();
} catch (LoaderError $e) {
    echo $e;
}