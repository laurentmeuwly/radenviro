<?php 
# src/AppBudle/Admin/LegendAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class LegendAdmin extends AbstractAdmin
{
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->addIdentifier('name_fr')
			->add('stations')
			->add('isotope')
			->add('color')
			->add('sorting')
			->add('hidden', 'boolean', array('editable' => true))
		;
	}
	
	protected function configureFormFields(FormMapper $formMapper)
	{
		
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		
	}
	
}