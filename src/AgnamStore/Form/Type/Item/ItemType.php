<?php

namespace AgnamStore\Form\Type\Item;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ItemType extends AbstractType {

    private $types;

    public function ItemType($type) {
        $this->types;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('price')
                ->add('name')
                ->add('year')
                ->add('author')
                ->add('image')
                ->add('description', 'textarea', array(
                    'attr' => array(
                        'rows' => '4',
                        'placeholder' => 'Entrer votre description ',
                    ),
                ))
                ->add('type', 'choice', array(
                    'choices' => selectType()
        ));
    }

    public function getName() {
        return 'user';
    }

    private function selectType() {

        foreach ($types as $type) {
            $array[$type->getId()] = $type->getLabel();
        }
        return $array;
    }

}