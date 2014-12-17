<?php

namespace AgnamStore\Form\Type\Item;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ItemType extends AbstractType {

    private $types;

    public function setType($types) {
        $this->types = $types;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('price','number')
                ->add('name','text')
                ->add('year','number')
                ->add('author','text')
                ->add('image','text')
                ->add('genres','hidden')
                ->add('description', 'textarea', array(
                    'attr' => array(
                        'rows' => '4',
                        'placeholder' => 'Entrer votre description ',
                    ),
                ))
                ->add('type', 'choice', array(
                    'choices' => $this->selectType()
        ));
    }

    public function getName() {
        return 'item';
    }

    /* * * *
     * Convert list of type on list using for select
     * 
     * Return array of label type with the key of typeId   
     * * * * * * * * * * */
    private function selectType() {

        foreach ($this->types as $type) {
            $array[$type->getId()] = $type->getLabel();
        }
        return $array;
    }

}
