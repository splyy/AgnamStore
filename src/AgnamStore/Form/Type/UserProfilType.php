<?php

namespace AgnamStore\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserProfilType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('email')
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
