<?php
// src/AppBundle/Form/RegistrationType.php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\FormBuilderInterface;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder
    	->add('firstname', null, array('label' => 'register.request.firstname'))
    	->add('lastname', null, array('label' => 'register.request.lastname'))
    	->add('laboratory', null, array('label' => 'register.request.laboratory'))
    	;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }
    
}