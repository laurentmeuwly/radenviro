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
		->add('name', null, array('label' => 'admin.network.name'))
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
		->with('General', array('class' => 'col-md-3', 'label' => 'admin.label.general'))
			->add('code')
			->add('networkCategory', null, array('label' => 'admin.network_category.name'))
		->end()
		->with('Informations', array('class' => 'col-md-6', 'label' => 'admin.label.informations'))
			->add('translations', TranslationsType::class, array(
					'label' => false,
					'fields' => array(
							'name'=> array('label' => 'admin.network.name')
					)
			))
		->end()
		->with('History', array('class' => 'col-md-3', 'label' => 'admin.label.history'))
		->add('createdAt', 'sonata_type_datetime_picker',  array('label' => 'admin.label.created_at',
				'attr' => array(
						'readonly' => true
				)
		))
		->add('updatedAt', 'sonata_type_datetime_picker', array('label' => 'admin.label.updated_at',
				'attr' => array(
						'readonly' => true
				)
		))
		->end()
		;
	}
}