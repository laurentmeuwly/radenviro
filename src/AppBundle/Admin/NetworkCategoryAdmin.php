<?php 
// src/AppBudle/Admin/NetworkCategoryAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class NetworkCategoryAdmin extends AbstractAdmin
{
	protected $translationDomain = 'AppBundle';
	
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
		->addIdentifier('name', null, array('label' => 'admin.network_category.name'))
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
		->with('General', array('class' => 'col-md-6', 'label' => 'admin.label.general'))
			->add('translations', TranslationsType::class, array(
					'label' => false,
					'fields' => array(
							'name'=> array('label' => 'admin.network_category.name')
					)
			))
		->end()
		->with('Attributs', array('class' => 'col-md-3', 'label' => 'admin.label.attributs'))
			->add('active', null, array('label' => 'admin.label.active'))
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