<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Member;
use App\Repository\MemberRepository;
use GuzzleHttp\Client;

class NominationsController extends AbstractController
{

    /**
     * @Route("/api/v1", name="api_home", methods={"GET"})
     */
    public function home() {

      $info = new \stdClass();
      $info->version = "1.0.0";
      $info->developer = "Ryan Pimentel";

      $response = new \stdClass();
      $response->status = true;
      $response->success = "Welcome to the SAG-AFTRA Nominations API";
      $response->info = $info;
      $response->http_code = 200;
      return new JsonResponse($response, 200);
    }

    /**
     * @Route("/api/v1/get-member", name="find_member", methods={"POST"})
     */
    public function find(Request $request) {

      $data = json_decode($request->getContent(), true);
      $id = $data['id'];
      $access_key = $data['access_key'];

      $em = $this->getDoctrine()->getManager();
      $query = $em->createQuery("
        SELECT m FROM App\Entity\Member m
        WHERE m.id = $id
          AND m.access_key = '".$access_key."'
      ");
      $results = $query->getArrayResult();

      $response = new \stdClass();

      if (empty($results)) {
        $response->message = "This is a locked route";
        $response->code = 401;
        return new JsonResponse($response, 401);
      }

        $reponse->message = "Member Information Found";
        $response->payload = $results;
        $response->code = 200;
        return new JsonResponse($response, 200);
    }

    /**
     * @Route("/members/", name="add_member", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $full_name = $data['full_name'];
        $sag_aftra_id = $data['sag_aftra_id'];
        $signing_route = "YWCBWCWW3S";
        $username = $data['username'];
        $administration_code = "ZBKULPlOTM";
        $access_key = "FHW9834ZHWDK2274DJWE743JQW4";
        $date_created = 1123452335;
        $good_standing = 1;
        $election_cycle_id = 1;
        $active = 1;

        if (empty($first_name) || empty($last_name) || empty($full_name) || empty($sag_aftra_id)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->memberRepository->saveMember($first_name, $last_name, $full_name, $sag_aftra_id, $signing_route, $username, $administration_code, $access_key, $date_created, $good_standing, $election_cycle_id, $active);

        return new JsonResponse(['status' => 'Member created!'], Response::HTTP_CREATED);
    }
}
