<?php

namespace AgnamStore\Form\Type\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('email')
                ->add('password', 'repeated', array(
                    'type' => 'password',
                    'invalid_message' => 'The password fields must match.',
                    'options' => array('required' => true),
                    'first_options' => array('label' => 'Password'),
                    'second_options' => array('label' => 'Repeat password'),
                ))
                ->add('firstName')
                ->add('lastName')
                ->add('address')
                ->add('city')
                ->add('cp');
    }

    public function getName() {
        return 'user';
    }

}
