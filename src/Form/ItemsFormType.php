<?php

namespace App\Form;

use App\Entity\Items;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class ItemsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('item_name', TextType::class,[
                'label' => 'Item Name',
                'attr' => array(
                    'class' => 'form-control mb-2'
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a item name',
                    ]),
                    new Regex('/^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]*$/'),
                ],
            ])
            ->add('color',ColorType::class,[
                'label' => 'Pick color',
                'attr' => array(
                    'class' => 'form-control mb-2'
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please select a color',
                    ]),
                ],
            ])->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary mb-3'],
            ]);

            if ($options['data']->getId() == NULL) {
                $builder->add('order_by',ChoiceType::class,[
                    'label' => 'Select a position',
                    'attr' => array(
                        'class' => 'mb-2'
                    ),
                    'choices' => [
                        'Place on top of list' => 'top',
                        'Place on bottom of list' => 'bottom',
                    ],
                    'expanded' => true,
                    'constraints' => [
                        new NotNull([
                            'message' => 'Please select a position',
                        ]),
                    ],
                ]);
            }
            
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Items::class,
        ]);
    }
}
