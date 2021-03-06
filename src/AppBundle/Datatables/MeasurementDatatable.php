<?php

namespace AppBundle\Datatables;

use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Style;
use Sg\DatatablesBundle\Datatable\Column\Column;
use Sg\DatatablesBundle\Datatable\Column\ActionColumn;
use Sg\DatatablesBundle\Datatable\Column\MultiselectColumn;
use Sg\DatatablesBundle\Datatable\Column\VirtualColumn;
use Sg\DatatablesBundle\Datatable\Column\DateTimeColumn;
use Sg\DatatablesBundle\Datatable\Filter\TextFilter;
use Sg\DatatablesBundle\Datatable\Filter\NumberFilter;
use Sg\DatatablesBundle\Datatable\Filter\SelectFilter;
use Sg\DatatablesBundle\Datatable\Filter\DateRangeFilter;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class MeasurementDatatable
 *
 * @package AppBundle\Datatables
 */
class MeasurementDatatable extends AbstractDatatable
{
	public function getListNuclide()
	{
		$session = new Session();
		if($session->get('displayList')>0) {
			$list = $session->get('displayList');
			$em = $this->em->getRepository('AppBundle\Entity\PredefinedNuclideList');
			return $em->findOneById($list);
		} else {
			$list = null;
		}
	}
	
	public function getSingleNuclide()
	{
		$session = new Session();
		if($session->get('nuclide')>0) {
			$nuclide = $session->get('nuclide');
			$em = $this->em->getRepository('AppBundle\Entity\Nuclide');
			return $em->findOneById($nuclide);
		} else {
			return null;
		}
		
	}
	
	public function getLineFormatter()
	{
		$formatter = function($row) {
			
			$em = $this->em->getRepository('AppBundle\Entity\Result');
			
			$listNuclide = $this->getListNuclide();
			if($listNuclide) {
				$nuclides = $listNuclide->getNuclides();
				foreach($nuclides as $nuclide)
				{
					$result = $em->findOneBy(array('measurement' => $row['id'], 'nuclide' => $nuclide->getNuclide()->getId()) );
					
					if($result) {
						
						if($result->getLimited()==1) {
							$value = '&lt;' . sprintf('%.1e', $result->getValue());
						} else {
							$value = sprintf('%.1e', $result->getValue());
						
							if($result->getError() != '') {
								$value .= ' &plusmn;'.sprintf('%.1e', $result->getError());
							}
							
						}
						$row[$nuclide->getNuclide()->getCode()] = $value;
						
					} else {
						$row[$nuclide->getNuclide()->getCode()] = '';
					}
					
				}
			}
			
			$singleNuclide = $this->getSingleNuclide();
			if($singleNuclide) {
				$result = $em->findOneBy(array('measurement' => $row['id'], 'nuclide' => $singleNuclide->getId()) );
				
				if($result) {
						
					if($result->getLimited()==1) {
						$value = '&lt;' . sprintf('%.1e', $result->getValue());
					} else {
						$value = sprintf('%.1e', $result->getValue());
							
						if($result->getError() != '') {
							$value .= ' &plusmn;'.sprintf('%.1e', $result->getError());
						}
				
					}
					$row[$singleNuclide->getCode()] = $value;
						
				} else {
					$row[$singleNuclide->getCode()] = '';
				}
			}
			return $row;
		};
	
		return $formatter;
	}
	
    /**
     * {@inheritdoc}
     */
    public function buildDatatable(array $options = array())
    {
        $this->language->set(array(
            'cdn_language_by_locale' => true
        ));

        $this->ajax->set(array(
        ));

        $this->options->set(array(
        	'classes' => Style::BOOTSTRAP_3_STYLE,
        	'length_menu' => [[10, 25, 50, -1], [10, 25, 50, $this->translator->trans('label.all')]],
            'individual_filtering' => true,
            'individual_filtering_position' => 'head',
            'order_cells_top' => true,
        	'order' => array(array(2, 'desc')),
        	'dom' => 'lBfrtip',
        ));
        
        $this->extensions->set(array(
        	//'buttons' => true,
        	'buttons' => array(
            	/*'show_buttons' => array('excel', 'csv'),*/    // built-in buttons
            	'create_buttons' => array(
            		array(
            			'extend' => 'print',
            			'button_options' => array(
            				'exportOptions' => array(
            					'columns' => ':visible:not(.not-export-col)',
            				),	
            			),
            		),
            		array(
            			'extend' => 'excel',
            			'button_options' => array(
            				'exportOptions' => array(
            					'columns' => ':visible:not(.not-export-col)',
            				),
            			),
            		),
            		array(
            			'extend' => 'csv',
            			'button_options' => array(
            				'exportOptions' => array(
            					'columns' => ':visible:not(.not-export-col)',
            				),
            			),
            		),
            	),
            ),
        ));

        $this->features->set(array(
        ));

        
        $this->columnBuilder
        	/*->add(null, MultiselectColumn::class, array(
        		'start_html' => '<div class="start_checkboxes">',
                'end_html' => '</div>',
        		'value' => 'id',
        		'value_prefix' => true,
        		//'render_actions_to_id' => 'sidebar-multiselect-actions', // custom Dom id for the actions
        		'actions' => array(
                        array(
                            'route' => 'printall',
                            'icon' => 'glyphicon glyphicon-ok',
                            'label' => 'Print all',
                            'attributes' => array(
                                'rel' => 'tooltip',
                                'title' => 'Print',
                                'class' => 'btn btn-primary btn-xs',
                                'role' => 'button',
                            ),
                            'confirm' => true,
                            'confirm_message' => 'Really?',
                            'start_html' => '<div class="start_print_action">',
                            'end_html' => '</div>',
                            
                        ),
                    ),
            ))*/
        		
        	->add('id', Column::class, array(
        		'title' => '#',
        		'visible' => false,
        	))
        	->add('sample.number', Column::class, array(
        		'title' => $this->translator->trans('table.sample'),
        	))
        	->add('referencedate', DateTimeColumn::class, array(
        		'title' => $this->translator->trans('table.refdate'),
        		'data' => 'referencedate',
        		'searchable' => true,
        		'orderable' => true,
        		'date_format' => 'YYYY-MM-DD',
        	))
        	
        	->add('laboratory.code', Column::class, array(
        			'title' => $this->translator->trans('table.laboratory'),
        	))
        	->add('sample.station.code', Column::class, array(
        			'title' => $this->translator->trans('table.station'),
        	))
        	->add('method.code', Column::class, array(
        			'title' => $this->translator->trans('table.method'),
        	))
        	->add('resultUnit.code', Column::class, array(
        			'title' => $this->translator->trans('table.unit'),
        			'searchable' => false,
        			'orderable' => false,
        	))
           
           /* ->add(null, ActionColumn::class, array(
                'title' => $this->translator->trans('sg.datatables.actions.title'),
                'actions' => array(
                    array(
                        'route' => 'measurement_show',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'label' => $this->translator->trans('sg.datatables.actions.show'),
                        'icon' => 'glyphicon glyphicon-eye-open',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('sg.datatables.actions.show'),
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button'
                        ),
                    ),
                    array(
                        'route' => 'measurement_edit',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'label' => $this->translator->trans('sg.datatables.actions.edit'),
                        'icon' => 'glyphicon glyphicon-edit',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('sg.datatables.actions.edit'),
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button'
                        ),
                    )
                )
            ))*/
        
        ;
        	
        	$listNuclide = $this->getListNuclide();
        	if($listNuclide) {
        		$nuclides = $listNuclide->getNuclides();
	        	foreach($nuclides as $nuclide)
	        	{
	        		$this->columnBuilder
	        		->add($nuclide->getNuclide()->getCode(), VirtualColumn::class, array(
	        				'title' => $nuclide->getNuclide()->getCode(),
	        				'type_of_field' => 'float',
	        				'searchable' => false,
	        				'orderable' => false,
	        		));
	        	}
        	}
        	$singleNuclide = $this->getSingleNuclide();
        	if($singleNuclide) {
        		$this->columnBuilder
        		->add($singleNuclide->getCode(), VirtualColumn::class, array(
        				'title' => $singleNuclide->getCode(),
        				'type_of_field' => 'float',
        				'searchable' => false,
        				'orderable' => false,
        		));
        	}
        	
        	$this->columnBuilder
        	->add(null, ActionColumn::class, array(
        			'title' => '',
        			'class_name' => 'not-export-col',
        			'start_html' => '<div class="start_actions">',
        			'end_html' => '</div>',
        			'actions' => array(
        					array(
        							'route' => 'printSample',
        							'label' => 'PDF',
        							'route_parameters' => array(
        									'id' => 'sample.number'
        							),
        	
        							'attributes' => array(
        									'rel' => 'tooltip',
        									'title' => 'Show',
        									'class' => 'btn btn-primary btn-xs',
        									'role' => 'button'
        							),
        							'start_html' => '<div class="start_show_action">',
        							'end_html' => '</div>',
        					)
        			)
        	));
        	
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'AppBundle\Entity\Measurement';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'measurement_datatable';
    }
}
