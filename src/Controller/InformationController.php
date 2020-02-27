<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Member;
use GuzzleHttp\Client;

class InformationController extends AbstractController
{

  /**
   * @Route("/api/v1/information/cycles", name="get_cycles", methods={"GET"})
   */
  public function getCycles() {

    $info = new \stdClass();
    $payload = new \stdClass();
    $now = time();

    $em = $this->getDoctrine()->getManager();
    $query = $em->createQuery("SELECT e FROM App\Entity\ElectionCycles e WHERE e.active = 1 AND e.date_start < " . $now . " AND e.date_end > " . $now);
    $payload->cycles = $query->getArrayResult();

    if (empty($payload->cycles)) {
      $response->status = false;
      $response->message = "No Election Cycles Found";
      $response->http_code = 200;
      return new JsonResponse($response, 200);
    } else {
      $response = new \stdClass();
      $response->status = true;
      $response->message = "Election Cycle Found";
      $response->payload = $payload->cycles[0];
      $response->http_code = 200;
      return new JsonResponse($response, 200);
    }
  }



}
