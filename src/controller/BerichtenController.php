<?php

namespace App\Controller;

use App\Entity\Bericht;
use App\Entity\BerichtRepo;
use App\Exception\NotAuthenticatedException;
use App\Mapper\BerichtMapper;
use Doctrine\ORM\EntityManager;
use Slim\Http\Request;
use Slim\Http\Response;

class BerichtenController extends Controller {
    public function get(Request $request, Response $response, $args) {
        /**
         * @var \Doctrine\ORM\EntityManager $em;
         */
        $em = $this->ci->get('em');
        $repo =  $em->getRepository('App\Entity\Bericht');

        $bericht = $repo->findOneById($args['id']);

        $response = $response
            ->withStatus(200)
            ->withJson(BerichtMapper::mapSingle($bericht));

        return $response;
    }

    public function index(Request $request, Response $response, $args) {
        $date = null;
        if (isset(
            $args['jaar'],
            $args['maand'],
            $args['dag']
        )) {
            $date = new \DateTime($args['jaar'] . '-' . $args['maand'] . '-' . $args['dag']);
        }

        /**
         * @var \Doctrine\ORM\EntityManager $em;
         */
        $em = $this->ci->get('em');
        /**
         * @var BerichtRepo $repo;
         */
        $repo =  $em->getRepository('App\Entity\Bericht');

        $berichten = null === $date ? $repo->getSortedAll() : $repo->getByDate($date);

        $mappedBerichten = BerichtMapper::mapCollection($berichten);

        //$response->headers->set('Content-Type', 'application/json');

        if (null === $date) {
            $date = new \DateTime();
        }
        $response = $response
            ->withStatus(200)
            ->withJson([
            "_timestamp" => $date->format('Y-m-d'),
            "_date" => $date->format('Y-m-d'),
            "_nextDate" => date("Y-m-d", strtotime("+1 day", strtotime($date->format('Y-m-d')))),
            "_prevDate" => date("Y-m-d", strtotime("-1 day", strtotime($date->format('Y-m-d')))),
            "messages" => $mappedBerichten
        ]);

        return $response;
    }

    public function post(Request $request, Response $response, $args) {
        $r = $this->requireAuthentication($request, $response);
        if (null !== $r) {
            return $r;
        }

        $post = $request->getParsedBody();

        /**
         * @var EntityManager $em
         */
        $em  = $this->ci->get('em');


        /**
         * @var BerichtRepo $repo
         */
        $repo = $em->getRepository('App\Entity\Bericht');

        if (isset($post['id']) && !empty($post['id'])) {
            $bericht = $repo->findOneById($post['id']);
            if (null === $bericht) {
                $bericht = new Bericht();
                $em->persist($bericht);
            }
        } else {
            $bericht = new Bericht();
            $em->persist($bericht);
        }


        // http://tourbuzz.nl/s/abc 24
        $sms_en   = isset($post['sms_en']) && strlen($post['sms_en']) >= 1 && strlen($post['sms_en']) <= 115 ? $post['sms_en'] : null;
        $sms_nl   = isset($post['sms_nl']) && strlen($post['sms_nl']) >= 1 && strlen($post['sms_nl']) <= 115 ? $post['sms_nl'] : null;
        $sms_de   = isset($post['sms_de']) && strlen($post['sms_de']) >= 1 && strlen($post['sms_de']) <= 115 ? $post['sms_de'] : null;

        $bericht->setSmsEn($sms_en);
        $bericht->setSmsNl($sms_nl);
        $bericht->setSmsDe($sms_de);
        $bericht->setTitle($post['title']);
        $bericht->setBody($post['body']);
        $bericht->setAdvice($post['advice']);
        $bericht->setTitleEn($post['title_en']);
        $bericht->setBodyEn($post['body_en']);
        $bericht->setAdviceEn($post['advice_en']);
        $bericht->setTitleDe($post['title_de']);
        $bericht->setBodyDe($post['body_de']);
        $bericht->setAdviceDe($post['advice_de']);
        $startDate = new \DateTime($post['startdate']);
        $bericht->setStartDate($startDate);
        $endDate = new \DateTime($post['enddate']);
        if ($startDate > $endDate) {
            $endDate = $startDate;
        }
        $bericht->setEndDate($endDate);
        $bericht->setLink($post['link']);
        $bericht->setIncludeMap($post['include_map'] ? true : false);
        if (isset($post['category'])) $bericht->setCategory($post['category']);
        if (isset($post['image_url'])) $bericht->setImageUrl($post['image_url']);
        $bericht->setImportant(isset($post['important']));
        $bericht->setIsLive(isset($post['is_live']));
        if (isset($post['location_lat'])) $bericht->setLocationLat($post['location_lat']);
        if (isset($post['location_lng'])) $bericht->setLocationLng($post['location_lng']);

        $em->flush();

        $response = $response->withJson(BerichtMapper::mapSingle($bericht));
        return $response;
    }

    public function delete(Request $request, Response $response, $args) {
        $r = $this->requireAuthentication($request, $response);
        if (null !== $r) {
            return $r;
        }

        /**
         * @var EntityManager $em
         */
        $em  = $this->ci->get('em');


        /**
         * @var BerichtRepo $repo
         */
        $repo = $em->getRepository('App\Entity\Bericht');

        $get = $request->getQueryParams();

        $ids = isset($args['id']) ? [$args['id']] : $get["ids"];
        foreach ($ids as $id) {
            $bericht = $repo->findOneById($id);
            if (null !== $bericht) {
                $em->remove($bericht);
            }
        }
        $em->flush();

        return $response;
    }
}