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
		
		$conn = mysqli_connect('10.203.210.10', 'envira', 'Cs-137');
		
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
		echo "Connected successfully";
		
		die();
		$connection = $this->container->get('doctrine.dbal.envira_connection');
		$connection->connect();
		if($connection->isConnected())
			echo 'OK'; else echo 'Not OK';
		//$connection->connect();
		var_dump($connection);die();
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