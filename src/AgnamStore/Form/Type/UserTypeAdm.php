<?php

namespace AgnamStore\Form\Type;


use Symfony\Component\Form\FormBuilderInterface;

class UserTypeAdm extends UserType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
                ->add('role', 'choice', array(
                    'choices' => array('ROLE_USER' => 'User','ROLE_ADMIN' => 'Admin')
                ));
        parent::buildForm($builder, $options);
    }
}
