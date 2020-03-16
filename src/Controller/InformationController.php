<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Member;
use App\Entity\ElectionCycles;
use GuzzleHttp\Client;

class InformationController extends AbstractController
{

  /**
   * @Route("/api/v1/information/cycles", name="get_cycles", methods={"GET"})
   */
  public function getCycles() {

    $response = new \stdClass();
    $payload = new \stdClass();

    $em = $this->getDoctrine()->getManager();
    $cycles = $em->getRepository(ElectionCycles::class)->findOneByActive();

    if (empty($cycles)) {
      $response->status = false;
      $response->message = "Election Cycle is Not Open";
      $response->http_code = 200;
      return new JsonResponse($response, 200);
    } else {
      $payload->election_year = $cycles->getElectionYear();
      $payload->active = ( $cycles->getActive() == true ? 1 : 0 );
      $response->status = true;
      $response->message = "Election Cycle is Open";
      $response->payload = $payload;
      $response->http_code = 200;
      return new JsonResponse($response, 200);
    }
  }



}
