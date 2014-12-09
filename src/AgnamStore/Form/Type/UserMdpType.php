<?php

namespace AgnamStore\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserMdpType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('password', 'repeated', array(
                    'type' => 'password',
                    'invalid_message' => 'The password fields must match.',
                    'options' => array('required' => true),
                    'first_options' => array('label' => 'Password'),
                    'second_options' => array('label' => 'Repeat password'),
        ));
    }

    public function getName() {
        return 'user';
    }

}
