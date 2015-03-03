<?php

namespace AgnamStore\Form\Type\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserRegistrationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('email'       , 'email'   , array('required' => TRUE))
                ->add('password', 'repeated', array(
                    'type' => 'password',
                    'invalid_message' => 'The password fields must match.',
                    'options' => array('required' => true),
                    'first_options' => array('label' => 'Password'),
                    'second_options' => array('label' => 'Repeat password'),
                ))                
                ->add('firstName'   , 'text'    , array('required' => TRUE))
                ->add('lastName'    , 'text'    , array('required' => TRUE))
                ->add('address'     , 'text'    , array('required' => TRUE))
                ->add('city'        , 'text'    , array('required' => TRUE))
                ->add('cp'          , 'number'  , array('required' => TRUE));;
    }

    public function getName() {
        return 'user';
    }

}
