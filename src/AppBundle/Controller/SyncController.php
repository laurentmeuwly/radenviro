<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Doctrine\DBAL\Connection;

class SyncController extends Controller
{
	
	/**
	 * @Route("/syncenvira", name="syncenvira")
	 */
	public function syncEnviraAction(Request $request)
	{

		$connection = $this->container->get('doctrine.dbal.envira_connection');
		$connection->connect();
		
		$sql = "SELECT * FROM canton";
		$stmt = $connection->query($sql); // Simple, but has several drawbacks
		while ($row = $stmt->fetch()) {
			echo $row['code'];
		}
		die();
		$admin_pool = $this->get('sonata.admin.pool');
		
		return $this->render('AppBundle:Sync:sync.html.twig', array(
				'admin_pool' => $admin_pool,
		));
	}

}