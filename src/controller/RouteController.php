<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;

class RouteController extends Controller
{
    /**
     * @var array
     */
    private $datasource;

    private $mapping = [
        'recommended' => 'recommended_routes',
        'mandatory' => 'mandatory_routes',
        'roadwork' => 'roadwork_routes',
    ];

    public function __construct($ci)
    {
        parent::__construct($ci);
        $this->datasource = $ci->get('settings')['datasource'];
    }

    public function index(Request $request, Response $response, $args)
    {
        if (isset($args['type'], $this->mapping[$args['type']]) === false) {
            return $response->withJson(['UNKNOWN TYPE'], 404);
        }

        try {
            $routes = $this->loadRouteData($this->datasource[$this->mapping[$args['type']]]);
            $results = [
                'type' => $args['type'],
                'routes' => [],
            ];
            foreach (array_pop($routes) as $route) {
                $route = array_pop($route);
                $key = md5($route['title'] . $route['Lokatie']);
                $results['routes'][$key] = [
                    'key' => $key,
                    'title' => $route['title']
                ];
            }
            $response = $response->withJson($results, 200);
        } catch (\Exception $e) {
            $this->ci->get('logger')->error('Exception while loading data from datasource', [
                'type' => get_class($e),
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            $response = $response->withJson(['ERROR'], 500);
        }

        return $response;
    }

    public function indexGeoJson(Request $request, Response $response, $args)
    {
        if (isset($args['type'], $this->mapping[$args['type']]) === false) {
            return $response->withJson(['UNKNOWN TYPE'], 404);
        }

        try {
            $routes = $this->loadRouteData($this->datasource[$this->mapping[$args['type']]]);
            $results = [
                'type' => 'FeatureCollection',
                'features' => [],
            ];
            foreach (array_pop($routes) as $route) {
                $route = array_pop($route);
                $key = md5($route['title'] . $route['Lokatie']);
                $feature = [
                    'type' => 'Feature',
                    'geometry' => json_decode($route['Lokatie']),
                    'properties' => [
                        'type' => $args['type'],
                        'key' => $key,
                    ]
                ];
                foreach ($route as $k => $v) {
                    if ($k !== 'Lokatie') {
                        $feature['properties'][$k] = $v;
                    }
                }
                $results['features'][] = $feature;
            }
            $response = $response->withJson($results, 200);
        } catch (\Exception $e) {
            $this->ci->get('logger')->error('Exception while loading data from datasource', [
                'type' => get_class($e),
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            $response = $response->withJson(['ERROR'], 500);
        }

        return $response;
    }

    public function detail(Request $request, Response $response, $args)
    {
        if (isset($args['type'], $this->mapping[$args['type']]) === false) {
            return $response->withJson(['UNKNOWN TYPE'], 404);
        }
        if (isset($args['key']) === false) {
            return $response->withJson(['KEY NOT SET'], 404);
        }

        try {
            $routes = $this->loadRouteData($this->datasource[$this->mapping[$args['type']]]);
            foreach (array_pop($routes) as $route) {
                $route = array_pop($route);
                $key = md5($route['title'] . $route['Lokatie']);
                if ($key === $args['key']) {
                    $results = [
                        'type' => 'Feature',
                        'geometry' => json_decode($route['Lokatie']),
                        'properties' => [
                            'type' => $args['type'],
                        ]
                    ];
                    foreach ($route as $k => $v) {
                        if ($k !== 'Lokatie') {
                            $results['properties'][$k] = $v;
                        }
                    }
                    $response = $response->withJson($results, 200);
                    break;
                }
            }
            $response = $response->withJson($results, 200);
        } catch (\Exception $e) {
            $this->ci->get('logger')->error('Exception while loading data from datasource', [
                'type' => get_class($e),
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            $response = $response->withJson(['ERROR'], 500);
        }

        return $response;
    }

    private function loadRouteData($url)
    {
        $client = new Client();
        $response = $client->get($url, []);
        return json_decode($response->getBody()->getContents(), true);
    }
}