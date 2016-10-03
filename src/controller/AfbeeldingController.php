<?php

namespace App\Controller;

use App\Service\ImageStoreService;
use Doctrine\ORM\EntityManager;
use Intervention\Image\ImageManager;
use Ramsey\Uuid\Uuid;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;

class AfbeeldingController {
    protected $ci;
    //Constructor
    public function __construct(\Interop\Container\ContainerInterface $ci) {
        $this->ci = $ci;
    }

    public function transform(Request $request, Response $response, $args) {
        /**
         * @var \SplFileInfo $fileInfo
         */
        $fileInfo = $this->ci->get('imageStore')->getFilePath($args['id']);

        if (null === $fileInfo) {
            throw new \Exception('Image not found');
        }

        $query = $request->getQueryParams();

        $realImage = new \SplFileInfo(getcwd() . '/' . $fileInfo);

        $manager = new ImageManager(["driver" => "imagick"]);
        $image = $manager->make($realImage->getRealPath());
        if (isset($query["greyscale"])) {
            $image->greyscale();
        }
        if (isset($query["method"])) {
            switch ($query["method"]) {
                case "fit":
                    $image->fit((int) $query["width"], $query["height"]);
                    break;
                case "resize":
                    $image->resize((int) $query["width"], (int) $query["height"]);
                    break;
            }
        }
        exit($image->response('jpg'));
    }

    public function post(Request $request, Response $response) {
        $files = $request->getUploadedFiles();
        if (!isset($files['file'])) {
            $response = $response
                ->withStatus('403')
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'file, Content-Type')
                ->withJson(['error' => 'No file included']);
            return $response;
        }

        /**
         * @var ImageStoreService $imageStore
         */
        $imageStore = $this->ci->get('imageStore');

        $image = $imageStore->store($files['file'], true);

        $response = $response
            ->withStatus(200)
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'file, Content-Type')
            ->withJson(['id' => $image->getId()]);
        return $response;
    }

    public function options(Request $request, Response $response) {
        $response = $response
            ->withStatus(200)
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'file, Content-Type');
        return $response;
    }
}