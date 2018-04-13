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

/**
 * Class LastResultDatatable
 *
 * @package AppBundle\Datatables
 */
class LastResultDatatable extends AbstractDatatable
{
	/**
	 * {@inheritdoc}
	 */
	public function getLineFormatter()
	{
		$formatter = function($row) {
			if($row['limited']==1) {
				$row['displayedValue'] = '&lt;' . sprintf('%.1e', $row['value']);				
			} else {
				$row['displayedValue'] = sprintf('%.1e', $row['value']);
			}
			if($row['error']>0)
				$row['error'] = sprintf('&plusmn %.1e', $row['error']);
	
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
            //'language' => 'de'
        ));

        $this->ajax->set(array(
        ));

        $this->options->set(array(
        		'classes' => Style::BOOTSTRAP_3_STYLE,
        		'individual_filtering' => false,
        		'individual_filtering_position' => 'head',
        		'order_cells_top' => false,
        ));
        
        $this->features->set(array(
        ));

        $this->columnBuilder
	    	->add('measurement.referencedate', DateTimeColumn::class, array(
	        	'title' => $this->translator->trans('table.refdate'),
	        	'data' => 'measurement.referencedate',
	        	'orderable' => false,
	        	'date_format' => 'YYYY-MM-DD',
	    	))
	        ->add('displayedValue', VirtualColumn::class, array(
	        	'title' => $this->translator->trans('table.value'),
	        	'searchable' => false,
	        	'orderable' => false,
	        ))
	        ->add('limited', Column::class, array(
	        	'title' => 'Value',
	        	'visible' => false,
	        ))
	        ->add('value', Column::class, array(
	        	'title' => 'Value',
	            'visible' => false,
	        ))
	        ->add('error', Column::class, array(
	            'title' => $this->translator->trans('table.error'),
	        	'orderable' => false,
	        ))
	        ->add('measurement.resultUnit.code', Column::class, array(
	        	'title' => $this->translator->trans('table.unit'),
	        	'orderable' => false,
	        ))
	        ->add('measurement.sample.station.code', Column::class, array(
	          	'title' => $this->translator->trans('table.station'),
	        	'orderable' => false,
	        ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'AppBundle\Entity\Result';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'lastresult_datatable';
    }
}
