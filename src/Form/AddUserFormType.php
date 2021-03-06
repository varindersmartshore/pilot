<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class AddUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class,[
                'label' => 'Username: ',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('email', EmailType::class,[
                'label' => 'Email: ',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'constraints' => [
                    new NotBlank(),
                    new Email()
                ],
            ])            
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary mt-3'],
            ])
        ;

        if ($options['data']->getId() == NULL) {
            $builder->add('profile', FileType::class, [
                'label' => 'Profile Picture',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            "image/png",
                            "image/jpg",
                            "image/jpeg"
                        ],
                        'mimeTypesMessage' => 'Please upload a valid jpg or png format',
                    ])
                ],
            ])
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
