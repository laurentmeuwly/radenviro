<?php 
// src/AppBudle/Admin/NuclideAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class LegendNuclideAdmin extends AbstractAdmin
{
	protected $parentAssociationMapping = 'legend'; // This does the trick..
	
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
		->add('nuclide')
		->add('position')
		;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
		->add('nuclide', 'sonata_type_model_list', ['btn_add'       => false, 'required' => false], [])
		->add('position', 'hidden')
		;
	}
}