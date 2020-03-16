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

  public function current_cycle() {
    return $this->getDoctrine()->getManager()->getRepository(ElectionCycles::class)->findOneByActive()->getId();
  }

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
   * @Route("/api/v1/administrate/add", name="admininistrate_add", methods={"POST"})
   */
  public function admininistrate_add(Request $request) {
    $data = json_decode($request->getContent(), true);
    $access_key = (isset($data['access_key']) ? $data['access_key'] : false);
    $member_id = $data['member_id'];
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
    $response->http_code = 200;

    return new JsonResponse($response, 200);
  }

  /**
   * @Route("/api/v1/administrate/all", name="admininistrate_all", methods={"GET"})
   */
  public function admininistrate_all(Request $request) {
    $data = json_decode($request->getContent(), true);
    $access_key = (isset($data['access_key']) ? $data['access_key'] : false);
    $response = new \stdClass();

    if (!$access_key) {
      $response->status = false;
      $response->message = "This is a locked route, please try again";
      $response->http_code = 401;
      return new JsonResponse($response, 401);
    }

    $em = $this->getDoctrine()->getManager();
    $admin = $em->getRepository(Member::class)->findOneByMemberAccessKey($access_key);
    $id = $admin->getId();

    if (!$admin) {
      $response->status = false;
      $response->message = "Member Record Could Not Be Found.";
      $response->http_code = 401;
      return new JsonResponse($response, 401);
    }

    $query = $em->createQuery("
      SELECT m.id, m.full_name FROM App\Entity\PetitionAdministration p
      INNER JOIN App\Entity\Member m
      WHERE p.members_id = m.id
      AND m.active = 1
      AND p.users_id = :id")
      ->setParameter('id' , $id);
    $results = $query->getArrayResult();

    if ($results) {
      $response->status = true;
      $response->message = "Candidates Found!";
      $response->payload = $results;
      $response->http_code = 200;
      return new JsonResponse($response, 200);
    } else {
      $response->status = false;
      $response->message = "No Candidates Found Associated to this Admin.";
      $response->http_code = 200;
      return new JsonResponse($response, 200);
    }

  }

  ##################################################### Nominations v3 Get Petition Information along with Statement, Signatures & Photos ###################################

  /**
   * @Route("/api/v1/administrate/member", name="admininistrate_current_petitions", methods={"GET"})
   */
  public function administrate_get_all_petitions(Request $request) {
    $data = json_decode($request->getContent(), true);
    $access_key = (isset($data['access_key']) ? $data['access_key'] : false);
    $member_id = $data['member_id'];
    $cycle = $this->current_cycle();
    $response = new \stdClass();

    if (!$access_key) {
      $response->status = false;
      $response->message = "This is a locked route, please try again";
      $response->http_code = 401;
      return new JsonResponse($response, 401);
    }

    $em = $this->getDoctrine()->getManager();
    $admin = $em->getRepository(Member::class)->findOneByMemberAccessKey($access_key);

    if (!$admin) {
      $response->status = false;
      $response->message = "Member Record Could Not Be Found.";
      $response->http_code = 401;
      return new JsonResponse($response, 401);
    }

    $query = $em->createQuery("
      SELECT p FROM App\Entity\Petitions p
      INNER JOIN App\Entity\Member m
      WHERE p.users_id = m.id
      AND p.users_id = :id")
      ->setParameter('id' , $member_id);
    $results = $query->getArrayResult();

    $national = array();
    $local = array();

    if ($results) {

    foreach ($results as $result) {

      $query = $em->createQuery("
        SELECT s.id FROM App\Entity\Statement s
        INNER JOIN App\Entity\Petitions p
        WHERE p.id = :id
        AND s.petition_id = p.id
        ORDER BY s.id DESC
        ")
        ->setParameter('id' , $result['id']);
      $query->setMaxResults(1);
      $statements = $query->getArrayResult();
      if ($statements) {
      $result['statement_id'] = $statements[0]['id'];
      }

      $info = $this->get_petition_info($result['election_board_positions_id']);
      $count = $this->get_signature_count($result['id']);

      $result['signature_count'] = $count;
      $result['info'] = $info;

      if ($result['national']) {
        array_push($national, $result);
      } else {
        array_push($local, $result);
      }
    }

    $petitions = new \stdClass();
    $petitions->national = $national;
    $petitions->local = $local;

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

  function get_signature_count($id) {
    $em = $this->getDoctrine()->getManager();
    $query = $em->createQuery("
      SELECT e.id FROM App\Entity\PetitionSignatures e
      WHERE e.id = :id
      ")
      ->setParameter('id' , $id);
    $result = $query->getArrayResult();

    $results = count($result);

    return $results;
  }


}
