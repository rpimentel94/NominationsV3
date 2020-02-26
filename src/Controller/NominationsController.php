<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
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
     * @Route("/api/v1/authenticate/member", name="member_athenticate", methods={"POST"})
     */
    public function member_authenticate(Request $request) {

      $data = json_decode($request->getContent(), true);
      $name = $data['username'];
      $ldappass = $data['password'];
      $response = new \stdClass();

      $username = "uid=".$name.",ou=people,dc=sag,dc=org";

      $ldap = ldap_connect("buub16-ldap-d.sag.org");
      ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
      ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
      if ($bind = ldap_bind($ldap, $username, $ldappass)) {
      @ldap_close($ldap);
      $em = $this->getDoctrine()->getManager();
      $query = $em->createQuery("
        SELECT m FROM App\Entity\Member m
        WHERE m.username = '".$name."'
      ");
      $results = $query->getArrayResult();
        if (empty($results)) {
          $member = $this->get_member_information($name);
          $insert = $this->member_create($member, $name);
          $access_key = $insert;
        } else {
          $access_key = $results[0]["access_key"];
        }
      $response->status = true;
      $response->success = "Member Authenticated Successfully";
      $response->access_key = $access_key;
      $response->http_code = 200;
      return new JsonResponse($response, 200);
      } else {
      return new JsonResponse("You're Really Bad At This!", 401);
      }
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

    function get_member_information($username) {

      try {
      $client = new \GuzzleHttp\Client(['base_uri' => 'https://sag-aftra-dev.apigee.net']);
      $request = $client->request('GET', '/registrationservice/finduser?uid=' . $username);

      $body = $request->getBody();
      $data = $body->getContents();
      $data = json_decode($data, true);
      $idn = $data['findUserResponse']['return']['idn'];

      $client = new \GuzzleHttp\Client(['base_uri' => 'https://sag-aftra-dev.apigee.net']);
      $request = $client->request('GET', '/memberprofileservice/findmemberbyidn?memberIdn=' . $idn);

      $body = $request->getBody();
      $member = $body->getContents();
      $member = json_decode($member, true);
      $member = $member['findMemberByIdnResponse']['return'];
      return $member;

      } catch (RequestException $exception) {
      return new JsonResponse("Staff Account Could Not Be Found!", 200);
      }
    }

    function member_create($member, $name) {
      $entityManager = $this->getDoctrine()->getManager();
      $account = new Member;
      $now = time();
      $hash_key = bin2hex(random_bytes(32));
      $signing_route = strtoupper(bin2hex(random_bytes(8)));
      $administration_code = strtoupper(bin2hex(random_bytes(8)));

      $account->setSagAftraId($member['unionId']);
      $account->setUsername($name);
      $account->setFirstName($member['professionalName']['firstName']);
      $account->setLastName($member['professionalName']['lastName']);
      $account->setFullName($member['professionalName']['firstName'] . " " . $member['professionalName']['lastName']);
      $account->setGoodStanding($member['goodStanding'] == true ? 1 : 0);
      $account->setAccessKey($hash_key);
      $account->setSigningRoute($signing_route);
      $account->setAdministrationCode($administration_code);
      $account->setElectionCycleId(1);
      $account->setActive(1);
      $account->setDateCreated($now);
      $entityManager->persist($account);
      $entityManager->flush();

      return $hash_key;
    }
}
