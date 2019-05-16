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
			->addIdentifier('id')
			->add('station.network')
			->add('station')
			->add('nuclide')
			->add('fluctuationMin')
			->add('fluctuation_max')
			->add('_active', 'boolean', array('label' => 'admin.label.active',
			    'editable' => true,
			    'header_style' => 'text-align: center',
			    'row_align' => 'center')
			    )
		    ->add('_action', 'actions', array(
		        'actions' => array(
		            'edit' => array(),
		        )
		    ))
		;
	}
	
	protected function configureFormFields(FormMapper $formMapper)
	{
	    $formMapper
	    ->with('General', array('class' => 'col-md-3', 'label' => 'admin.label.general'))
	    ->add('id')
	    //->add('networkCategory', null, array('label' => 'admin.network_category.name'))
	    ->add('fluctuationMin')
	    ->add('fluctuationMax')
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
	    ->add('station.network')
	    ->add('station', 'doctrine_orm_callback', array(
	        'callback'   => array($this, 'callbackFilterStation'),
	        'field_type' => 'checkbox'
	    )
	    )
	    
	    //->add('station')
	    //->add('samdate', 'doctrine_orm_datetime', array('field_type'=>'sonata_type_datetime_picker',))
	    //->add('samdate', 'doctrine_orm_datetime_range', array('field_type'=>'sonata_type_datetime_range_picker',))
	    
	    ;
	}
	
	public function callbackFilterStation($queryBuilder, $alias, $field, $value)
	{
	    if(!is_array($value) or !array_key_exists('value', $value)
	        or empty($value['value'])){
	            return;
	    }
	    
	    $queryBuilder
	    ->leftJoin(sprintf('%s.station', $alias), 's')
	    ->leftJoin('s.network', 'n')
	    ->andWhere('n.id = :id')
	    ->setParameter('id', $value['value'])
	    ;
	    var_dump($queryBuilder);
	    die();
	    return true;
	}
	
}