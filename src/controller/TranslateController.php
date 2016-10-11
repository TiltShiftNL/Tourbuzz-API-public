<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class TranslateController extends Controller {

    public function translate(Request $request, Response $response, $args)
    {
        $r = $this->requireAuthentication($request, $response);
        if (null !== $r) {
            return $r;
        }

        if (!in_array(strtolower($args['lang']),['en','es','de','fr'])) {
            $response = $response
                ->withStatus(406)
                ->withJson(['error' => 'Unsupported language']);
            return $response;
        }

        $settings = $this->ci->get('settings');
        $uri = "https://www.googleapis.com/language/translate/v2?key=" .
            $settings['translateApiKey'] .
            "&source=nl&target=" .
            strtolower($args['lang']) .
            "&q=";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri . urlencode($args['string']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);

        $obj = json_decode($json);

        if (isset($obj->error)) {
            $response = $response->withStatus(407)->withJson($obj);
            return $response;
        }

        $response = $response->withJson(['string' => $obj->data->translations[0]->translatedText]);
        return $response;
    }
}