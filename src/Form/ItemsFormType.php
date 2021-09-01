<?php

namespace App\Form;

use App\Entity\Items;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('item_name', TextType::class,[
                'label' => 'Item Name',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a item name',
                    ]),
                ],
            ])
            ->add('color',ColorType::class,[
                'label' => 'Pick color',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please select a color',
                    ]),
                ],
            ])
            ->add('order_by',ChoiceType::class,[
                'label' => 'Select a position',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'choices' => [
                    'Place on top of list' => 'top',
                    'Place on bottom of list' => 'bottom',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please select a position',
                    ]),
                ],
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary mt-3'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Items::class,
        ]);
    }
}
