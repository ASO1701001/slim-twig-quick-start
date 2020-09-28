<?php
namespace Application\Controller;

use Application\App\Database;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Controller {
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function render(
        ServerRequestInterface $request,
        ResponseInterface $response,
        string $template,
        array $data = []): ResponseInterface  {
        $view = Twig::fromRequest($request);
        try {
            return $view->render($response, $template, $data);
        } catch (LoaderError $e) {
            $response->getBody()->write("LoaderError...");
            return $response;
        } catch (RuntimeError $e) {
            $response->getBody()->write("RuntimeError...");
            return $response;
        } catch (SyntaxError $e) {
            $response->getBody()->write("SyntaxError...");
            return $response;
        }
    }
}