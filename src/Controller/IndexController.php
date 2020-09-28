<?php
namespace Application\Controller;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class IndexController extends Controller {
    public function get(Request $request, Response $response) {
        return $this->render($request, $response, "index.twig");
    }
}