<?php 
// src/AppBudle/Admin/SampleAdmin.php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Sonata\CoreBundle\Form\Type\DateTimeRangePickerType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class SampleAdmin extends AbstractAdmin
{
    protected $datagridValues = [
        '_page' => 1,
        '_per_page' => 16,
        '_sort_order' => 'DESC',
        '_sort_by' => 'samdate'
    ];
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        unset($this->listModes['mosaic']);
         
        $listMapper
        ->addIdentifier('number', null, ['label' => 'admin.sample.number'])
        ->add('description', null, ['label' => 'admin.sample.description', 'sortable' => false])
        ->add('station', null, ['label' => 'admin.sample.station'])
        ->add('network', null, ['label' => 'admin.sample.network'])
        ->add('samdate', null, ['label' => 'admin.sample.date', 'format'=>'Y-m-d'])
        ->add('mtime', null, ['label' => 'admin.sample.modified', 'format'=>'Y-m-d H:i'])
        ->add('_action', null, [
            'actions' => [
                'delete' => array()
                ]
            ])
        ;
    }
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('network', null, ['show_filter'=>true, 'advanced_filter' => false])
        ->add('station', null, ['show_filter'=>true, 'advanced_filter' => false])
        ->add('number', null, ['show_filter'=>true, 'advanced_filter' => false])
        ->add('samdate', 'doctrine_orm_datetime_range', [
            'show_filter'=>true,
            'field_type'=>'sonata_type_datetime_range_picker',
            'field_options' => [
                'field_options' => [
                    'format' => 'dd.MM.yyyy'
                ]
            ]
        ])
        ;
    }
}