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

class StaffController extends AbstractController
{

    /**
     * @Route("/api/v1/authenticate/staff", name="staff_authenticate")
     */
     public function staff_authenticate(Request $request) {

        $data = json_decode($request->getContent(), true);
        $username = $data['username'];
        $password = $data['password'];

        $adServer = "ldap://bumsdc01.sag.org";

        $ldap = ldap_connect($adServer);

        $ldaprdn = 'sag' . "\\" . $username;

        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
        try {
        $bind = ldap_bind($ldap, $ldaprdn, $password);
        @ldap_close($ldap);
        } catch(\Exception $e){
        return new JsonResponse("Account Failed to Authenticate", 401);
        }
        $member = $this->staff_find($username);
        return new JsonResponse($member, 200);
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

}
