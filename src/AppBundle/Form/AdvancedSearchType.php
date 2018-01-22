<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Network;
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
					//'property' => 'name',
					'placeholder' => 'search.choose_network',
					'label' => 'search.field.network',
					'query_builder' => function (EntityRepository $er) {
						return $er->createQueryBuilder('n')
						->where('n.active=1');
					},
					//'data' => $session->get('network'),
			))
			->add('displayList', 'entity', array(
					'mapped' => false,
					'class' => 'AppBundle:PredefinedNuclideList',
					//'property' => 'name',
					'placeholder' => 'search.choose_displaylist',
					'label' => 'search.field.displaylist',
					'query_builder' => function (EntityRepository $er) {
					return $er->createQueryBuilder('l')
					->where('l.active=1');
					},
					//'data' => $session->get('network'),
					))
			->add('search', SubmitType::class, array('label' => 'label.search'))
		;
	}
	
	
}