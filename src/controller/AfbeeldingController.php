<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Intervention\Image\ImageManager;
use Slim\Http\Request;
use Slim\Http\Response;

class AfbeeldingController {
    protected $ci;
    //Constructor
    public function __construct(\Interop\Container\ContainerInterface $ci) {
        $this->ci = $ci;
    }

    public function transform(Request $request, Response $response, $args) {
        $fileInfo = $this->ci->get('imageStore')->getFilePath($args['id']);

        if (null === $fileInfo) {
            throw new \Exception('Image not found');
        }

        $query = $request->getQueryParams();

        $manager = new ImageManager(["driver" => "imagick"]);
        $image = $manager->make($fileInfo);
        if (isset($query["greyscale"])) {
            $image->greyscale();
        }
        if (isset($query["method"])) {
            switch ($query["method"]) {
                case "fit":
                    $image->fit((int) $_GET["width"], $_GET["height"]);
                    break;
                case "resize":
                    $image->resize((int) $_GET["width"], (int) $_GET["height"]);
                    break;
            }
        }
        exit($image->response('jpg'));
    }
}