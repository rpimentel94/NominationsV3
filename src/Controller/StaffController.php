<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Staff;
use App\Repository\MemberRepository;
use GuzzleHttp\Client;

class StaffController extends AbstractController
{

    /** Symfony Commands to make life easlier
    *
    */

    /*
    composer dump-autoload --classmap-authoritative "Class can not be found in blah"

    */

    /**
     * @Route("/api/v1/authenticate/staff", name="staff_authenticate")
     */
     public function staff_authenticate(Request $request) {

        $data = json_decode($request->getContent(), true);
        $username = $data['username'];
        $password = $data['password'];
        $response = new \stdClass();
        $payload = new \stdClass();

        $adServer = "ldap://bumsdc01.sag.org";

        $ldap = ldap_connect($adServer);
        $ldaprdn = 'sag' . "\\" . $username;
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
        try {
        $bind = ldap_bind($ldap, $ldaprdn, $password);
        @ldap_close($ldap);
        } catch(\Exception $e) {
          $response->status = false;
          $response->message = "Staff Failed to Authenticate";
          $response->http_code = 401;
          return new JsonResponse($response, 401);
        }
        $staff = $this->staff_find($username);

        if ($staff) {
          $em = $this->getDoctrine()->getManager();
          $query = $em->createQuery("
            SELECT s FROM App\Entity\Staff s
            WHERE s.username = '".$username."'
          ");
          $results = $query->getArrayResult();
          if (empty($results)) {
            if (strpos($staff['dn'], 'Terminated') !== false) {
            $response->status = false;
            $response->message = "Your Account is not Authorized to Access this Application";
            $response->http_code = 401;
            return new JsonResponse($response, 401);
            }
            $payload->insert = $this->staff_create($staff);
            $response->status = true;
            $response->message = "Staff Authenticated Successfully";
            $response->payload = $payload;
            $response->http_code = 200;
            return new JsonResponse($response, 200);
           } else {
            $payload->access_key = $results[0]["access_key"];
            $response->status = true;
            $response->message = "Staff Authenticated Successfully";
            $response->payload = $payload;
            $response->http_code = 200;
            return new JsonResponse($response, 200);
          }
        }
    }


    function staff_find($username) {

      try {
      $client = new \GuzzleHttp\Client(['base_uri' => 'http://adapi.sagaftra.org']);
      $request = $client->request('GET', '/user/show/' . $username);

      $body = $request->getBody();
      $data = $body->getContents();

      return json_decode($data, true);
      } catch (RequestException $exception) {
      return new JsonResponse("Staff Account Could Not Be Found!", 200);
      }
    }

    function staff_create($staff_info) {
      $entityManager = $this->getDoctrine()->getManager();
      $staff = new Staff;
      $now = time();
      $hash_key = bin2hex(random_bytes(32));

      $staff->setUsername($staff_info['data']['samaccountname']);
      $staff->setElection($staff_info['data']['location']);
      $staff->setAccessKey($hash_key);
      $staff->setElectionCyclesId(1);
      $staff->setActive(1);
      $staff->setDateCreated($now);
      $staff->setDateModified($now);
      $entityManager->persist($staff);
      $entityManager->flush();

      return $hash_key;
    }

}
