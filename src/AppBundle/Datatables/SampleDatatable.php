<?php

namespace AppBundle\Datatables;

use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Style;
use Sg\DatatablesBundle\Datatable\Column\Column;
//use Sg\DatatablesBundle\Datatable\Column\BooleanColumn;
use Sg\DatatablesBundle\Datatable\Column\ActionColumn;
//use Sg\DatatablesBundle\Datatable\Column\MultiselectColumn;
use Sg\DatatablesBundle\Datatable\Column\VirtualColumn;
use Sg\DatatablesBundle\Datatable\Column\DateTimeColumn;
use Sg\DatatablesBundle\Datatable\Column\NumberColumn;
//use Sg\DatatablesBundle\Datatable\Column\ImageColumn;
//use Sg\DatatablesBundle\Datatable\Filter\TextFilter;
//use Sg\DatatablesBundle\Datatable\Filter\NumberFilter;
//use Sg\DatatablesBundle\Datatable\Filter\SelectFilter;
//use Sg\DatatablesBundle\Datatable\Filter\DateRangeFilter;
//use Sg\DatatablesBundle\Datatable\Editable\CombodateEditable;
//use Sg\DatatablesBundle\Datatable\Editable\SelectEditable;
//use Sg\DatatablesBundle\Datatable\Editable\TextareaEditable;
//use Sg\DatatablesBundle\Datatable\Editable\TextEditable;

/**
 * Class SampleDatatable
 *
 * @package AppBundle\Datatables
 */
class SampleDatatable extends AbstractDatatable
{
	
	public function getLineFormatter()
	{
		$formatter = function($row) {
			$temp = array('Cs-137', 'H-3', 'Cs-134', 'Co-60', 'K-40', 'Rh-106', 'I-131');
			//$row['test'] = 'Test';
			
			foreach($temp as $nuclide) {
				if($nuclide=='K-40') $row[$nuclide] = '<6.710e-06';
				else $row[$nuclide] = $row['number'];
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
    	$temp = array('Cs-137', 'H-3', 'Cs-134', 'Co-60', 'K-40', 'Rh-106', 'I-131');
    	
        $this->language->set(array(
            'cdn_language_by_locale' => true
            //'language' => 'de'
        ));

        $this->ajax->set(array(
        ));

        $this->options->set(array(
        	'classes' => Style::BOOTSTRAP_3_STYLE,
            'individual_filtering' => true,
            'individual_filtering_position' => 'head',
            'order_cells_top' => true,
        	'global_search_type' => 'gt',
        	'search_in_non_visible_columns' => true,
        	'order_multi' => true,
        	'order_classes' => true,
        		'dom' => 'Bfrtip',
        ));

        
        // ne fonctionne pas
        $this->features->set(array(
        		'info' => true,
        		'paging' => true,
        		'searching' => true,
        		'scroll_x' => false,
        		'length_change' => true,
        ));
        
        $this->extensions->set(array(
        		'responsive' => false,
        		'buttons' => false,
        		/*'buttons' => array(
        				//'show_buttons' => array('copy', 'print'),
        				'create_buttons' => array(
        						array(
        								'extend' => 'csv',
        								'text' => 'Export CSV',
        						),
        						array(
        								'extend' => 'pdf',
        								//'orientation' => 'landscape',
        								'button_options' => array(
        										'exportOptions' => array(
        												'columns' => $this->getPdfColumns(),
        										),
        								),
        						),
        				),
        		),*/
        		
        ));
        
      /*  $this->callbacks->set(array(
        		'init_complete' => array(
        				'template' => ':callback:init.js.twig',
        		),
        ));*/

        $this->columnBuilder
            ->add('id', Column::class, array(
                'title' => 'Id',
            	'visible' => false,
                ))
            ->add('number', Column::class, array(
                'title' => 'Number',
                ))
            ->add('measurements.referencedate', DateTimeColumn::class, array(
                'title' => 'RefDate',
                'data' => 'measurements[, ].referencedate',
            	'searchable' => true,
        		'orderable' => false,
            	'date_format' => 'YYYY-MM-DD',
                ))
            ->add('laboratory.code', Column::class, array(
                'title' => 'Laboratory Code',
                ))
            ->add('network.code', Column::class, array(
                'title' => 'Network',
            	'visible' => false,
                ))
            ->add('station.code', Column::class, array(
                'title' => 'Station',
                ))
            ->add('measurements.method.code', Column::class, array(
                'title' => 'Method',
                'data' => 'measurements[, ].method.code'
                ))
            ->add('measurements.resultUnit.code', Column::class, array(
            	'title' => 'Unit',
            	'data' => 'measurements[, ].resultUnit.code',
            	'searchable' => false,
            	'orderable' => false,
            	))
            /*->add('result_count', Column::class, array(
            	'title' => '# res',
            	'dql' => '(SELECT COUNT({r}) FROM AppBundle:Result {r} WHERE {r}.measurement=982 AND {r}.nuclide=26)',
            	
            	))
            	*/
            
           
      /*  ->add(null, ActionColumn::class, array(
        		'title' => $this->translator->trans('sg.datatables.actions.title'),
        		'actions' => array(
        				array(
        						'route' => 'post_show',
        						'route_parameters' => array(
        								'id' => 'id',
        						),
        						'label' => $this->translator->trans('sg.datatables.actions.show'),
        						'icon' => 'glyphicon glyphicon-eye-open',
        						'attributes' => array(
        								'rel' => 'tooltip',
        								'title' => $this->translator->trans('sg.datatables.actions.show'),
        								'class' => 'btn btn-primary btn-xs',
        								'role' => 'button',
        						),
        				),
        		),
        	))*/
        ;
            
        /*foreach($temp as $nuclide) {
        	$this->columnBuilder
        	->add($nuclide, VirtualColumn::class, array(
            	'title' => $nuclide,
            	));
        }*/
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'AppBundle\Entity\Sample';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sample_datatable';
    }
    
    /**
     * Returns the columns which are to be displayed in a pdf.
     *
     * @return array
     */
    private function getPdfColumns()
    {
    	return array(
    		'1', // sample code column
    		'2', // date column
    		'3', // laboratory column
    		'4', // station column
    		'5', // method column
    		'6', // unit column
    		'7', // nuclide #1 column
    		'8', // nuclide #2 column
    	);
    	
    }
    
}
