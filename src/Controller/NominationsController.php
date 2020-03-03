<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use App\Entity\Member;
use App\Entity\MemberLocal;
use App\Entity\MemberInformation;
use App\Entity\ElectionCycles;
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
      $response->message = "Welcome to the SAG-AFTRA Nominations API";
      $response->info = $info;
      $response->http_code = 200;
      return new JsonResponse($response, 200);
    }

    public function current_cycle() {
    return $this->getDoctrine()->getManager()->getRepository(ElectionCycles::class)->findOneByActive()->getId();
    }

    /**
     * @Route("/api/v1/authenticate/member", name="member_athenticate", methods={"POST"})
     */
    public function member_authenticate(Request $request) {

      $data = json_decode($request->getContent(), true);
      $name = $data['username'];
      $ldappass = $data['password'];
      $response = new \stdClass();
      $payload = new \stdClass();

      $username = "uid=".$name.",ou=people,dc=sag,dc=org";
      $ldap = ldap_connect("buub16-ldap-d.sag.org");
      ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
      ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
      try {
      $bind = ldap_bind($ldap, $username, $ldappass);
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
          $payload->access_key = $insert;
        } else {
          $update = $this->update_member_information($name, $results[0]);
          $update = $this->update_member_local($name, $results[0]);
          $payload->access_key = $results[0]["access_key"];
        }
      $response->status = true;
      $response->message = "Member Authenticated Successfully";
      $response->payload = $payload;
      $response->http_code = 200;
      return new JsonResponse($response, 200);
      } catch(\Exception $e) {
      $response->status = false;
      $response->message = "Member Failed to Authenticate";
      $response->http_code = 401;
      return new JsonResponse($response, 401);
      }
    }

    function get_member_information($username) {

      try {
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://sag-aftra-dev.apigee.net/dev-registrationservice/v1/user?uid=" . $username,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array("x-apikey:  hSa8SYHhxc0c5QAhXOmaWoxwJRPMVukq"),
      ));
      $response = curl_exec($curl);
      $response = json_decode($response, true);
      $idn = $response['idn'];

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://sag-aftra-dev.apigee.net/memberprofileservice/findmemberbyidn?memberIdn=". $idn,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array("x-apikey:  hSa8SYHhxc0c5QAhXOmaWoxwJRPMVukq"),
      ));
      $response = curl_exec($curl);
      $member = json_decode($response, true);
      return $member['findMemberByIdnResponse']['return'];

      } catch (RequestException $exception) {
      return new JsonResponse("Staff Account Could Not Be Found!", 200);
      }
    }

    function member_create($member, $name) {
      $cycle = $this->current_cycle();
      $entityManager = $this->getDoctrine()->getManager();
      $account = new Member;
      $date = new \DateTime('@'.strtotime('now'));
      $now = $date->format('Y-m-d H:i:s');
      $hash_key = bin2hex(random_bytes(32));
      $signing_route = strtoupper(bin2hex(random_bytes(4)));
      $administration_code = strtoupper(bin2hex(random_bytes(4)));

      $account->setSagAftraId($member['unionId']);
      $account->setUsername($name);
      $account->setFirstName($member['professionalName']['firstName']);
      $account->setLastName($member['professionalName']['lastName']);
      $account->setFullName($member['professionalName']['firstName'] . " " . $member['professionalName']['lastName']);
      $account->setGoodStanding($member['goodStanding'] == true ? 1 : 0);
      $account->setAccessKey($hash_key);
      $account->setSigningRoute($signing_route);
      $account->setAdministrationCode($administration_code);
      $account->setElectionCyclesId($cycle);
      $account->setActive(1);
      $account->setDateCreated($now);
      $entityManager->persist($account);
      $entityManager->flush();

      $user_id = $account->getId();

      $local = new MemberLocal;
      $local->setUsersId($user_id);
      $local->setElectionCyclesId($this->current_cycle());
      $local->setDescription($member['branch']['description']);
      $local->setCode($member['branch']['code']);
      $local->setActive(1);
      $local->setOverride(0);
      $local->setDateCreated($now);
      $entityManager->persist($local);
      $entityManager->flush();

      return $hash_key;
    }

    function update_member_information($name, $db_record){
      $member = $this->get_member_information($name);
      $date = new \DateTime('@'.strtotime('now'));
      $now = $date->format('Y-m-d H:i:s');
      $oracle_name = $member['professionalName']['firstName'] . " " . $member['professionalName']['lastName'];
      $oracle_standing = ($member['goodStanding'] == true ? 1 : 0);

      if ($oracle_name != $db_record['full_name'] || $oracle_standing != $db_record['good_standing']) {
        $em = $this->getDoctrine()->getManager();
        $update = $em->getRepository(Member::class)->findOneByUserId($db_record['id']);
        $update->setFullName($oracle_name);
        $update->setFirstName($member['professionalName']['firstName']);
        $update->setLastName($member['professionalName']['lastName']);
        $update->setGoodStanding($member['goodStanding']);
        $update->setDateModified($now);
        $em->flush();
      }
    }

    function update_member_local($name, $db_record){
      $member = $this->get_member_information($name);
      $cycle = $this->current_cycle();
      $oracle_local = $member['branch']['code'];
      $id = $db_record['id'];
      $date = new \DateTime('@'.strtotime('now'));
      $now = $date->format('Y-m-d H:i:s');
      $match = false;
      $em = $this->getDoctrine()->getManager();
      $query = $em->createQuery("SELECT e FROM App\Entity\MemberLocal e WHERE e.active = 1 AND e.override != 1 AND e.users_id = ".$id." ");
      $locals = $query->getArrayResult();

      if (empty($locals)) {
        $local = new MemberLocal;
        $local->setUsersId($id);
        $local->setElectionCyclesId($cycle);
        $local->setDescription($member['branch']['description']);
        $local->setCode($member['branch']['code']);
        $local->setActive(1);
        $local->setOverride(0);
        $local->setDateCreated($now);
        $em->persist($local);
        $em->flush();
        return true;
        }

        foreach ($locals as $local) {
          if ($local['code'] == $member['branch']['code']) {
            $match = true;
          } else {
            $previous = $local['code'];
          }
        }

        if (!$match) {
          $override = 0;
          $qb = $em->createQueryBuilder();
          $q = $qb->update('App\Entity\MemberLocal', 'u')
                  ->set('u.active', '?1')
                  ->where('u.users_id = ?2')
                  ->andWhere('u.override = ?3')
                  ->andWhere('u.code = ?4')
                  ->setParameter(1, 0)
                  ->setParameter(2, ''.$id.'')
                  ->setParameter(3, ''.$override.'')
                  ->setParameter(4, ''.$previous.'')
                  ->getQuery();
          $p = $q->execute();

          $em = $this->getDoctrine()->getManager();
          $new_local = new MemberLocal;
          $cycle = $this->current_cycle();
          $new_local->setUsersId($id);
          $new_local->setElectionCyclesId($cycle);
          $new_local->setDescription($member['branch']['description']);
          $new_local->setCode($member['branch']['code']);
          $new_local->setActive(1);
          $new_local->setOverride(0);
          $new_local->setDateCreated($now);
          $em->persist($new_local);
          $em->flush();

        }
    }

    /**
     * @Route("/api/v1/petitions/member/all", name="member_local_national", methods={"POST"})
     */
    public function member_find_national_local_boards(Request $request) {
      $data = json_decode($request->getContent(), true);
      $access_key = $data['access_key'];
      $response = new \stdClass();

      $em = $this->getDoctrine()->getManager();
      $query = $em->createQuery("SELECT m FROM App\Entity\Member m WHERE m.active = 1 AND m.access_key = '".$access_key."'");
      $results = $query->getArrayResult();

      if (empty($results) || !$access_key) {
        $response->status = false;
        $response->message = "This is a locked route, please try again";
        $response->http_code = 401;
        return new JsonResponse($response, 401);
      }

      return new JsonResponse("You've successfully used the access key to authenticate", 200);

    }

    /**
     * @Route("/api/v1/petitions/member/contact-information/save", name="member_save_contact_information", methods={"POST"})
     */
    public function member_save_contact_information(Request $request) {
      $response = new \stdClass();
      $data = json_decode($request->getContent(), true);
      $access_key = (isset($data['access_key']) ? $data['access_key'] : false);

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

      $errors = false;
      $messages = new \stdClass();

      if ( !$data['phone'] || strlen($data['phone']) > 30 ) {
        $errors = true;
        $messages->phone = "Telephone is required & Can not be greater than a length of 30 characters.";
      }

      if ( !filter_var($data['email'], FILTER_VALIDATE_EMAIL) || !$data['email'] ) {
        $errors = true;
        $messages->email = "Email is required & needs to be valid.";
      }

      if ( !$data['address_1']) {
        $errors = true;
        $messages->address = "Address Line 1 is required";
      }

      if ( !$data['city']) {
        $errors = true;
        $messages->city = "City is required";
      }

      if ( !$this->validCityState($data['city'])) {
        $errors = true;
        $messages->city = "City is not valid";
      }

      if ( !$data['state']) {
        $errors = true;
        $messages->state = "State is required";
      }

      if ( !$this->validCityState($data['state'])) {
        $errors = true;
        $messages->state = "State is not valid";
      }

      $media_contact = false;
      if ( $data['media_contact'] == 1 || $data['media_contact'] == true || $data['media_contact'] == 'true' ) {
        $media_contact = true;
      }

      if ($media_contact) {
        if ( !$data['media_phone'] || strlen($data['media_phone']) > 30 ) {
          $errors = true;
          $messages->phone = "Media Telephone is required & Can not be greater than a length of 30 characters.";
        }
        if ( !filter_var($data['media_email'], FILTER_VALIDATE_EMAIL) || !$data['media_email'] ) {
          $errors = true;
          $messages->phone = "Media Email is required & needs to be valid.";
        }
      }

      if ($errors) {
        $response->status = false;
        $response->message = "Contact Information Errors Found";
        $response->payload = $messages;
        $response->http_code = 200;
        return new JsonResponse($response, 200);
      }

      try {
      $date = new \DateTime('@'.strtotime('now'));
      $now = $date->format('Y-m-d H:i:s');
      $em = $this->getDoctrine()->getManager();
      $member_contact_info = new MemberInformation;
      $cycle = $this->current_cycle();
      $member_contact_info->setUsersId($data['users_id']);
      $member_contact_info->setBallotDisplayName($data['ballot_display_name']);
      $member_contact_info->setAddress1($data['address_1']);
      $member_contact_info->setAddress2($data['address_2']);
      $member_contact_info->setCity($data['city']);
      $member_contact_info->setState($data['state']);
      $member_contact_info->setZipCode($data['zip_code']);
      $member_contact_info->setCountry($data['country']);
      $member_contact_info->setEmail($data['email']);
      $member_contact_info->setPhone($data['phone']);
      $member_contact_info->setMediaContact($media_contact);
      $member_contact_info->setMediaEmail($data['media_email']);
      $member_contact_info->setMediaPhone($data['media_phone']);
      $member_contact_info->setElectionCyclesId($cycle);
      $member_contact_info->setActive(1);
      $member_contact_info->setDateCreated($now);
      $member_contact_info->setDateModified($now);
      $em->persist($member_contact_info);
      $em->flush();

      $response->status = true;
      $response->message = "Contact Information Saved Successfully!";
      $response->http_code = 200;
      return new JsonResponse($response, 200);

      } catch (RequestException $exception) {
        $response->status = false;
        $response->message = "Contact Information Failed to Save!!";
        $response->http_code = 200;
        return new JsonResponse($response, 200);
      }

    }

    /**
     * @Route("/api/v1/petitions/member/contact-information/edit", name="member_edit_contact_information", methods={"POST"})
     */
    public function member_edit_contact_information(Request $request) {
      $response = new \stdClass();
      $data = json_decode($request->getContent(), true);
      $access_key = (isset($data['access_key']) ? $data['access_key'] : false);

      if (!$access_key) {
        $response->status = false;
        $response->message = "This is a locked route, please try again";
        $response->http_code = 401;
        return new JsonResponse($response, 401);
      }

      $em = $this->getDoctrine()->getManager();
      $member = $em->getRepository(Member::class)->findOneByMemberAccessKey($access_key);
    }

    /**
     * @Route("/api/v1/petitions/member/contact-information", name="member_contact_information", methods={"GET"})
     */
    public function member_contact_information(Request $request) {
      $response = new \stdClass();
      $data = json_decode($request->getContent(), true);
      $access_key = (isset($data['access_key']) ? $data['access_key'] : false);

      if (!$access_key) {
        $response->status = false;
        $response->message = "This is a locked route, please try again";
        $response->http_code = 401;
        return new JsonResponse($response, 401);
      }

      $em = $this->getDoctrine()->getManager();
      $member = $em->getRepository(Member::class)->findOneByMemberAccessKey($access_key);

      $result = $em->createQueryBuilder();
      $member_contact_info = $result->select('m')
            ->from('App\Entity\MemberInformation', 'm')
            ->where('m.users_id = :id')
            ->setParameter('id', $member->getId())
            ->getQuery()
            ->getArrayResult();

      $response->status = true;
      $response->message = "Contact Information Found!";
      $response->payload = $member_contact_info;
      $response->http_code = 200;
      return new JsonResponse($response, 200);

    }

    function validCityState($search) {
      try {
      $client = new \GuzzleHttp\Client(['base_uri' => 'https://www.weather-forecast.com']);
      $request = $client->request('GET', '/locations/ac_location_name?query=' . $search);
      $body = $request->getBody();
      $response = $body->getContents();

      if (strlen($response) > 6) { return true; } else { return false; }

      } catch (RequestException $exception) {
      return new JsonResponse("City could not be validated at this time.", 200);
      }
    }

    public function toArray() {
        return get_object_vars($this);
    }

}
