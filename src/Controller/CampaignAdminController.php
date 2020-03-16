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
use App\Entity\PetitionAdministration;
use GuzzleHttp\Client;

class CampaignAdminController extends AbstractController
{

  /**
   * @Route("/api/v1/administrate/find", name="admininistrate_find", methods={"GET"})
   */
  public function admininistrate_find(Request $request) {

    $data = json_decode($request->getContent(), true);
    $access_key = (isset($data['access_key']) ? $data['access_key'] : false);
    $admin_code = $data['admin_code'];
    $response = new \stdClass();

    if (!$access_key) {
      $response->status = false;
      $response->message = "This is a locked route, please try again";
      $response->http_code = 401;
      return new JsonResponse($response, 401);
    }

    $em = $this->getDoctrine()->getManager();
    $member = $em->getRepository(Member::class)->findOneByMemberAccessKey($access_key);

    if (!$member) {
      $response->status = false;
      $response->message = "Member Record Could Not Be Found.";
      $response->http_code = 401;
      return new JsonResponse($response, 401);
    }

    $user = $em->getRepository(Member::class)->findOneByAdminCode($admin_code);

    if (!$user) {
      $response->status = false;
      $response->message = "Not Account Found With This Administration Code!";
      $response->http_code = 200;
    } else {

      $payload = new \stdClass();
      $payload->id = $user->getId();
      $payload->name = $user->getFullName();

      $response->status = true;
      $response->message = "Account Found!";
      $response->payload = $payload;
      $response->http_code = 200;
    }

    return new JsonResponse($response, 200);

  }

  /**
   * @Route("/api/v1/administrate/add", name="admininistrate_add", methods={"GET"})
   */
  public function admininistrate_add(Request $request) {
    $data = json_decode($request->getContent(), true);
    $access_key = (isset($data['access_key']) ? $data['access_key'] : false);
    $member_id = $data['id'];
    $response = new \stdClass();

    if (!$access_key) {
      $response->status = false;
      $response->message = "This is a locked route, please try again";
      $response->http_code = 401;
      return new JsonResponse($response, 401);
    }

    $em = $this->getDoctrine()->getManager();
    $member = $em->getRepository(Member::class)->findOneByMemberAccessKey($access_key);
    $user_id = $member->getId()''

    if (!$member) {
      $response->status = false;
      $response->message = "Member Record Could Not Be Found.";
      $response->http_code = 401;
      return new JsonResponse($response, 401);
    }

    $date = new \DateTime('@'.strtotime('now'));
    $now = $date->format('Y-m-d H:i:s');
    $em = $this->getDoctrine()->getManager();
    $admin = new PetitionAdministration;
    $admin->setUsersId($users_id);
    $admin->setMembersId($member_id);
    $admin->setActive(1);
    $admin->setDateCreated($now);
    $em->persist($admin);
    $em->flush();

    $response->status = true;
    $response->message = "Member & Campaign Admin Associated Successfully!";
    $response->payload = $payload;
    $response->http_code = 200;

    return new JsonResponse($response, 200);
  }

}
