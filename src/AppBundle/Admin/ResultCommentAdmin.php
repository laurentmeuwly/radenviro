<?php 
// src/AppBudle/Admin/ResultCommentAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class ResultCommentAdmin extends AbstractAdmin
{
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
		->add('dateFrom', null, ['label' => 'admin.resultcomment.datefrom'])
		->add('dateTo', null, ['label' => 'admin.resultcomment.dateto'])
		->add('station', null, ['label' => 'admin.resultcomment.station'])
		->add('network', null, ['label' => 'admin.resultcomment.network'])
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
			->add('dateFrom', DateType::Class, [
				'label' => 'admin.resultcomment.datefrom',
				'widget' => 'choice',
				'years' => range(date('Y')-40, date('Y')+20),
				])
			->add('dateTo', DateType::Class, [
				'label' => 'admin.resultcomment.dateto',
				'widget' => 'choice',
				'years' => range(date('Y')-40, date('Y')+20),
				])
			->add('station', null, ['label' => 'admin.resultcomment.station'])
			->add('network', null, ['label' => 'admin.resultcomment.network'])
			->add('active', null, ['label' => 'admin.label.active'])
		->end()
		->with('Informations', array('class' => 'col-md-6', 'label' => 'admin.label.informations'))
			->add('translations', TranslationsType::class, [
				'label' => false,
				'fields' => [
						'comment' => [
								'field_type' => 'ckeditor',
								'label' => 'admin.label.description',
						]		
				]
				
			])
		->end()
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
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
		->add('active', null, ['operator_type' => 'sonata_type_boolean', 'label' => 'admin.label.active'])
		->add('station')
		//->add('translations.name', null, ['label' => 'admin.network.name'])
		;
	}
}