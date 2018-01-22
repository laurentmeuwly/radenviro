<?php

namespace AppBundle\Datatables;

use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Style;
use Sg\DatatablesBundle\Datatable\Column\Column;
use Sg\DatatablesBundle\Datatable\Column\BooleanColumn;
use Sg\DatatablesBundle\Datatable\Column\ActionColumn;
use Sg\DatatablesBundle\Datatable\Column\MultiselectColumn;
use Sg\DatatablesBundle\Datatable\Column\VirtualColumn;
use Sg\DatatablesBundle\Datatable\Column\DateTimeColumn;
use Sg\DatatablesBundle\Datatable\Column\ImageColumn;
use Sg\DatatablesBundle\Datatable\Filter\TextFilter;
use Sg\DatatablesBundle\Datatable\Filter\NumberFilter;
use Sg\DatatablesBundle\Datatable\Filter\SelectFilter;
use Sg\DatatablesBundle\Datatable\Filter\DateRangeFilter;
use Sg\DatatablesBundle\Datatable\Editable\CombodateEditable;
use Sg\DatatablesBundle\Datatable\Editable\SelectEditable;
use Sg\DatatablesBundle\Datatable\Editable\TextareaEditable;
use Sg\DatatablesBundle\Datatable\Editable\TextEditable;
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
		} else {
			$list = 1;
		} 
		$em = $this->em->getRepository('AppBundle\Entity\PredefinedNuclideList');
		return $em->findOneById($list);
	}
	
	public function getLineFormatter()
	{
		$formatter = function($row) {
			
			$em = $this->em->getRepository('AppBundle\Entity\Result');
			
			$listNuclide = $this->getListNuclide()->getNuclides();
			foreach($listNuclide as $nuclide) 
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
            //'cdn_language_by_locale' => true
            'language' => 'fr'
        ));

        $this->ajax->set(array(
        ));

        $this->options->set(array(
        	'classes' => Style::BOOTSTRAP_3_STYLE,
            'individual_filtering' => true,
            'individual_filtering_position' => 'head',
            'order_cells_top' => true,
        ));

        $this->features->set(array(
        ));

        
        $this->columnBuilder
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
        		'orderable' => false,
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
        	
        	$listNuclide = $this->getListNuclide()->getNuclides();
        	foreach($listNuclide as $nuclide)
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
