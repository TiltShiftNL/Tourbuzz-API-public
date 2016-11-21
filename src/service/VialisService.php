<?php

namespace App\Service;

use App\Entity\Bericht;
use App\Entity\BerichtRepo;
use App\Entity\Mail;
use App\Entity\MailRepo;
use App\Entity\ParkeerplaatsDynamicXref;
use App\Entity\VialisDynamic;
use App\Entity\VialisDynamicRepo;
use App\Exception\MailExistsException;
use App\Exception\NoMailException;
use App\Mapper\VialisDynamicMapper;
use App\View\Mail\NewsletterMail;
use App\View\Mail\RegisterMail;
use App\View\Mail\UnsubscribeMail;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Ramsey\Uuid\Uuid;

class VialisService {


    /**
     * @var \Interop\Container\ContainerInterface
     */
    protected $ci;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var VialisDynamicRepo
     */
    protected $dynamicRepo;

    /**
     * @var string
     */
    protected $dynamicUrl = 'http://opd.it-t.nl';

    /**
     * @var string
     */
    protected $dynamicPath = '/data/amsterdam/dynamic/';

    /**
     * MailService constructor.
     * @param \Interop\Container\ContainerInterface $ci
     */
    public function __construct(ContainerInterface $ci) {
        $this->ci        = $ci;
        $this->em        = $this->ci->get('em');
        $this->dynamicRepo  = $this->em->getRepository('App\Entity\VialisDynamic');
    }

    public function update() {
        $html = file_get_contents($this->dynamicUrl . $this->dynamicPath);
        $dom = new \DOMDocument();
        $dom->loadHTML($html);

        $pres = $dom->getElementsByTagName('pre');

        if (isset($pres[0])) {
            /**
             * @var \DOMElement $pre
             */
            $pre = $pres[0];

            $links = $pre->getElementsByTagName('a');

            foreach ($links as $link) {
                /**
                 * @var \DOMElement $link
                 */
                $href = $link->getAttribute('href');

                if ('/data/amsterdam/' === $href) {
                    continue;
                }

                $this->processLink($this->dynamicUrl . $href);
            }
        }
        $this->em->flush();
        echo "Done\n";
    }

    protected function processLink($link) {
        $json = \GuzzleHttp\json_decode(file_get_contents($link), true);

        if (!isset($json['parkingFacilityDynamicInformation'])) {
            echo "ERROR: link '" . $link ."' does not have parkingFacilityDynamicInformation, skipping\n";
            return;
        }

        $obj = $json['parkingFacilityDynamicInformation'];

        $dynamic = $this->dynamicRepo->findOneByVialisId($obj['identifier']);

        if (null === $dynamic) {
            $dynamic = new VialisDynamic();
            $dynamic->setVialisId($obj['identifier']);
            $this->em->persist($dynamic);
        }

        $dynamic->setDescription($obj['description']);
        $dynamic->setName($obj['name']);

        $status = $obj['facilityActualStatus'];

        $dynamic->setIsFull($status['full']);
        $lastUpdated = new \DateTime();
        $lastUpdated->setTimestamp($status['lastUpdated']-3600);
        $dynamic->setLastUpdated($lastUpdated);
        $dynamic->setOpen($status['open']);
        $dynamic->setCapacity($status['parkingCapacity']);
        $dynamic->setVacant($status['vacantSpaces']);
        $dynamic->setLastPull(new \DateTime());
    }

    public function map($parkeerplaats, $dynamicId) {
        $dynamic = $this->dynamicRepo->findOneById($dynamicId);
        if (null === $dynamic) {
            return false;
        }

        $repo = $this->em->getRepository('App\Entity\ParkeerplaatsDynamicXref');
        $xref = $repo->findOneByParkeerplaats($parkeerplaats);
        if (null === $xref) {
            $xref = new ParkeerplaatsDynamicXref();
            $this->em->persist($xref);
            $xref->setParkeerplaats($parkeerplaats);
        }
        $xref->setVialisDynamic($dynamic);
        $this->em->flush();
        return true;
    }

    public function getForParkeerplaats($parkeerplaats) {
        $repo = $this->em->getRepository('App\Entity\ParkeerplaatsDynamicXref');
        /**
         * @var ParkeerplaatsDynamicXref $xref
         */
        $xref = $repo->findOneByParkeerplaats($parkeerplaats);
        if (null === $xref) {
            return null;
        }
        return VialisDynamicMapper::mapSingle($xref->getVialisDynamic());
    }
}