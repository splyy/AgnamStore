<?php

namespace AgnamStore\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserRoleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('role', 'choice', array(
                    'choices' => array('ROLE_USER' => 'User', 'ROLE_ADMIN' => 'Admin')
        ));
    }

    public function getName() {
        return 'user';
    }

}
