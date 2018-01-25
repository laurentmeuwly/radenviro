<?php 
// src/AppBudle/Admin/NuclideAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class NuclideAdmin extends AbstractAdmin
{
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
		->addIdentifier('code', null, array('label' => 'admin.nuclide.code'))
		->add('name', null, array('label' => 'admin.nuclide.name'))
		->add('active', 'boolean', array('label' => 'admin.label.active',
				'editable' => true,
				'header_style' => 'text-align: center',
				'row_align' => 'center')
				)
		
		/*->add('_action', null, array(
				'actions' => array(
						'show' => array(),
						'edit' => array(),
						'delete' => array(),
				)
		))*/
		;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
		->with('Nuclide', array('class' => 'col-md-6'))
		->add('code', null, array('label' => 'admin.nuclide.code'))
		->add('translations', TranslationsType::class, array(
				'label' => false,
				'fields' => array(
						'name'=> array('label' => 'admin.nuclide.name')
				)
		))
		->add('active', null, array('label' => 'admin.label.active'))
		->end()
		;
	}
}