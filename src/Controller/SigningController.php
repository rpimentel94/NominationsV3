<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Member;
use App\Entity\PetitionSignatures;
use GuzzleHttp\Client;

class SigningController extends AbstractController
{
  /**
   * @Route("/api/v1/petitions/find", name="get_petitions_by_signing_route", methods={"GET"})
   */
   public function get_petitions_by_signing_route(Request $request) {
     $data = json_decode($request->getContent(), true);
     $access_key = $data['access_key'];
     $signing_route = $data['signing_route'];
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
       $response->status = true;
       $response->message = "No Member Can Be Found With Signing Route";
       $response->http_code = 200;
       return new JsonResponse($response, 200);
     }

     $signatures = $this->get_member_signing_history($member->getId());

     $signed = array();
     foreach ($signatures as $signature) {
       array_push($signed, $signature['petition_id']);
     }

     $query = $em->createQuery("
       SELECT p FROM App\Entity\Petitions p
       INNER JOIN App\Entity\Member m
       WHERE p.users_id = m.id
       AND m.signing_route = :hash")
       ->setParameter('hash' , $signing_route);
     $results = $query->getArrayResult();

     $national = array();
     $local = array();
     $signing_locals = array();

     foreach ($results as $result) {

       if (in_array($result['id'], $signed)) {
         $result['already_signed'] = true;
       } else {
         $result['already_signed'] = false;
       }

       $info = $this->get_petition_info($result['election_boards_id']);
       $result['info'] = $info;

       if ($result['national']) {
         array_push($national, $result);
       } else {
         array_push($signing_locals, $result['info'][0]['id']);
         array_push($local, $result);
       }
     }

     $is_good_standing = $member->getGoodStanding();
     $member_locals = $this->get_member_local($member->getId());

     foreach ($member_locals as $member_local) {
       if ($member_local['id'] === $signing_locals[0]) {
         $check = 1;
       } else {
         $check = 0;
       }
     }

     $petitions = new \stdClass();
     $petitions->member_standing = $is_good_standing;
     $petitions->local_check = $check;
     $petitions->national = $national;
     $petitions->local = $local;

     if ($results) {
     $response->status = true;
     $response->message = "Petitions Found!";
     $response->payload = $petitions;
     $response->http_code = 200;
     return new JsonResponse($response, 200);
     } else {
       $response->status = true;
       $response->message = "Memeber Has Not Submitted Any Petitions";
       $response->http_code = 200;
       return new JsonResponse($response, 200);
     }
  }

  function get_petition_info($board_id) {
    $em = $this->getDoctrine()->getManager();
    $query = $em->createQuery("
      SELECT e.id, e.position, e.position_2, e.signatures_required, e.delegate, p.boards_name, p.date_end, p.timezone FROM App\Entity\ElectionBoardPositions e
      INNER JOIN App\Entity\ElectionBoards p
      WHERE e.id = :id
      AND e.election_boards_id = p.id
      ")
      ->setParameter('id' , $board_id);
    $result = $query->getArrayResult();

    $timezone = new \DateTimeZone($result[0]['timezone']);
    $date_end = $result[0]['date_end'];
    $end = new \DateTime($date_end, $timezone);
    $result[0]['display_date'] = $end->format('n/d/Y g:ia T');

    return $result;
  }

  function get_member_local($id) {
    $em = $this->getDoctrine()->getManager();
    $query = $em->createQuery("
      SELECT e.id, e.description, e.code FROM App\Entity\MemberLocal e
      WHERE e.active = 1
      AND e.override != 1
      AND e.users_id = ".$id."
      ");
    $locals = $query->getArrayResult();
    return $locals;
  }

  function get_member_signing_history($id) {
    $em = $this->getDoctrine()->getManager();
    $query = $em->createQuery("
      SELECT p.petition_id FROM App\Entity\PetitionSignatures p
      WHERE p.active = 1
      AND p.users_id = ".$id."
      ");
    $petitions = $query->getArrayResult();
    return $petitions;
  }

  /**
   * @Route("/api/v1/petitions/sign-petitions", name="sign_petitions", methods={"POST"})
   */
   public function sign_petitions(Request $request) {
     $data = json_decode($request->getContent(), true);
     $access_key = $data['access_key'];
     $petitions = $data['petitions'];
     $response = new \stdClass();

     if (!$access_key) {
       $response->status = false;
       $response->message = "This is a locked route, please try again";
       $response->http_code = 401;
       return new JsonResponse($response, 401);
     }

     $em = $this->getDoctrine()->getManager();
     $member = $em->getRepository(Member::class)->findOneByMemberAccessKey($access_key);
     $users_id = $member->getId();

     if (!$member) {
       $response->status = true;
       $response->message = "No Member Can Be Found With Signing Route";
       $response->http_code = 200;
       return new JsonResponse($response, 200);
     }

     $date = new \DateTime('@'.strtotime('now'));
     $now = $date->format('Y-m-d H:i:s');

     foreach ( $petitions as $petition ) {
       $em = $this->getDoctrine()->getManager();
       $signature = new PetitionSignatures;
       $signature->setUsersId($users_id);
       $signature->setPetitionId($petition);
       $signature->setActive(1);
       $signature->setDateCreated($now);
       $em->persist($signature);
       $em->flush();
     }

     $response->status = true;
     $response->message = "Petitions Signed Successfully!";
     $response->http_code = 200;
     return new JsonResponse($response, 200);

   }
}
