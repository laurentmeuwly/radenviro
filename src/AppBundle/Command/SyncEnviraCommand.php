<?php

namespace AppBundle\Command;
 
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Filesystem\Filesystem;
use XMLReader;
use DOMDocument;

 
class SyncEnviraCommand extends ContainerAwareCommand
{
	private $tabStats;
	
	protected function configure()
    {
        // Name and description for app/console command
        $this
        ->setName('sync:envira')
        ->setDescription('Synchronize Envira into Radenviro')
        ->addArgument('type');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$syncService = $this->getContainer()->get('app.synchronizer');
    	
    	$type = $input->getArgument('type');
    	switch ($type) {
    		// only new values will be imported
    		case 'new':
    			$result = $syncService->synchronize();
    			break;
    		
    		// only updated values will be imported
    		case 'mod':
    			break;
    			
    		// only values in destination and not more in source will be threated
    		case 'del':
    			break;
    			
    		// execution of the whole process
    		case 'all':
    			break;
    			
    		// by default, only new values will be imported
    		default:
    			$result = $syncService->synchronize();
    			break;
    	}
    }
    
}