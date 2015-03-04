<?php

namespace AgnamStore\Form\Type\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserProfilType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('email', 'email', array('required' => TRUE))
                ->add('firstName', 'text', array('required' => TRUE))
                ->add('lastName', 'text', array('required' => TRUE))
                ->add('address', 'text', array('required' => TRUE))
                ->add('city', 'text', array('required' => TRUE))
                ->add('cp', 'text', array(
                    'required' => TRUE,
                    'constraints' => array(new \Symfony\Component\Validator\Constraints\Regex(array(
                            'pattern' => '#^[0-9]{5}$#',
                            'match' => TRUE,
                            'message' => 'Votre Code postal est incorrect'
                        )))));
    }

    public function getName() {
        return 'user';
    }

}
