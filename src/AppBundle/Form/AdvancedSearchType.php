<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Entity\Network;
use AppBundle\Entity\Nuclide;
use AppBundle\Entity\PredefinedNuclideList;



class AdvancedSearchType extends AbstractType
{
	/* @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('network', 'entity', array(
					'mapped' => false,
					'class' => 'AppBundle:Network',
					'placeholder' => 'search.choose_network',
					'label' => 'search.field.network',
					'query_builder' => function (EntityRepository $er) {
							return $er->createQueryBuilder('n')
							->where('n.active=1');
					},
			))
			->add('displayList', 'entity', array(
					'mapped' => false,
					'required' => false,
					'class' => 'AppBundle:PredefinedNuclideList',
					'placeholder' => 'search.choose_displaylist',
					'label' => 'search.field.displaylist',
					'query_builder' => function (EntityRepository $er) {
					return $er->createQueryBuilder('l')
							->where('l.active=1')
							->orderBy('l.position', 'asc');
					},
			))
			->add('nuclide', 'entity', array(
					'mapped' => false,
					'required' => false,
					'class' => 'AppBundle:Nuclide',
					'placeholder' => 'search.choose_nuclide',
					'label' => 'search.field.nuclide',
					'query_builder' => function (EntityRepository $er) {
					return $er->createQueryBuilder('n')
							->where('n.active=1');
					},				
			))
			->add('search', SubmitType::class, array('label' => 'label.search'))
		;
	}

}