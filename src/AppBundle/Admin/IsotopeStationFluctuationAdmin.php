<?php 
# src/AppBudle/Admin/BagCodeAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class IsotopeStationFluctuationAdmin extends AbstractAdmin
{
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->add('station.network')
			->add('station')
			->add('nuclide')
			->add('fluctuationMin', NumberType::class, ['scale' => 4])
			->add('fluctuationMax', NumberType::class)
			->add('_active', 'boolean', ['label' => 'admin.label.active',
			    'editable' => true,
			    'header_style' => 'text-align: center',
			    'row_align' => 'center']
			    )
		    ->add('_action', 'actions', [
		        'actions' => [
					'edit' => [],
					]
				])
		;
	}
	
	protected function configureFormFields(FormMapper $formMapper)
	{
	    $formMapper
		->with('General', ['class' => 'col-md-3', 'label' => 'admin.label.general'])
		//->add('translations.name', null, ['label' => 'admin.station.name'])
		->add('station.network', null, ['label' => 'admin.network.name',
			'attr' => [
				'readonly' => true
			]
		])
		->add('station.code', null, ['label' => 'admin.station.code',
			'attr' => [
				'readonly' => true
			]
		])
		->add('nuclide.code', null, ['label' => 'admin.nuclide.code',
			'attr' => [
				'readonly' => true
			]
		])
		->end()
	    ->with('Fluctuations', ['class' => 'col-md-3', 'label' => 'admin.label.values'])
	    ->add('fluctuationMin', null, ['label' => 'admin.fluctuationmin'])
		->add('fluctuationMax', null, ['label' => 'admin.fluctuationmax'])
		->add('active', null, array('label' => 'admin.label.active'))
	    ->end()
	    
	    ->with('History', ['class' => 'col-md-3', 'label' => 'admin.label.history'])
	    ->add('createdAt', 'sonata_type_datetime_picker',  ['label' => 'admin.label.created_at',
	        'attr' => [
	            'readonly' => true
			]
		])
	    ->add('updatedAt', 'sonata_type_datetime_picker', ['label' => 'admin.label.updated_at',
	        'attr' => [
	            'readonly' => true
			]
		])
	    ->end()
	    ;
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
	    $datagridMapper
	    ->add('station.network', null, ['show_filter'=>true])
	    ->add('station', null, [
			'show_filter'=>true,
	        //'callback'   => array($this, 'callbackFilterStation'),
	        //'field_type' => 'checkbox'
	    ]
	    )
	    
	    //->add('station')
	    //->add('samdate', 'doctrine_orm_datetime', array('field_type'=>'sonata_type_datetime_picker',))
	    //->add('samdate', 'doctrine_orm_datetime_range', array('field_type'=>'sonata_type_datetime_range_picker',))
	    
	    ;
	}
	
	public function callbackFilterStation($queryBuilder, $alias, $field, $value)
	{
	    /*if(!is_array($value) or !array_key_exists('value', $value)
	        or empty($value['value'])){
	            return;
	    }*/
	    
	    $queryBuilder
	    ->leftJoin(sprintf('%s.station', $alias), 's')
	    ->andWhere('code like \'%POS%\'')
	    ;
	    /*var_dump($queryBuilder);
	    die();*/
	    return true;
	}
	
}