<?php 
// src/AppBudle/Admin/NetworkAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class NetworkAdmin extends AbstractAdmin
{
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
		->addIdentifier('code')
		->add('name')
		//->add('networkCategory.name')
		->add('_active', 'boolean', array('label' => 'admin.label.active',
				'editable' => true,
				'header_style' => 'text-align: center',
				'row_align' => 'center')
				)
		->add('_action', 'actions', array(
				'actions' => array(
						'edit' => array(),
						'delete' => array(),
				)
			))
		;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
		->with('General', array('class' => 'col-md-6'))
			->add('code')
		->end()
		->with('Translations', array('class' => 'col-md-6'))
			->add('translations', TranslationsType::class)
		->end()
		->with('Additional infos', array('class' => 'col-md-12'))
		->add('networkCategory', 'entity', array(
				'class' => 'AppBundle\Entity\NetworkCategory'
				))
		->end()
		;
	}
}