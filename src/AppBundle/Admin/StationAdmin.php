<?php 
# src/AppBudle/Admin/StationAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class StationAdmin extends AbstractAdmin
{
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->addIdentifier('code')
			->add('name_fr')
			->add('name_de')
			->add('network.name_fr')
			->add('stationType.code')
		;
	}
	
	protected function configureFormFields(FormMapper $formMapper)
	{
		
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('code')
			->add('stationType', null, array(), 'entity', array(
					'class' => 'AppBundle\Entity\StationType',
					'choice_label' => 'code',
			))
		;
	}
	
}