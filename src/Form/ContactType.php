<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class,[
                'attr' => [
                    'class' =>'form-control',
                    'minlength'=>'2',
                    'maxlength'=>'50',
                ],
                'label'=>false,
                'label_attr'=>[
                    'class' =>'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('email', EmailType::class,[
                'attr' => [
                    'class' =>'form-control',
                    'minlength'=>'2',
                    'maxlength'=>'180',
                ],
                'label'=>false,
                'label_attr'=>[
                    'class' =>'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min'=> 2 , 'max'=>180])
                ]
            ])
            ->add('subject', TextType::class,[
                'attr' => [
                    'class' =>'form-control',
                    'minlength'=>'2',
                    'maxlength'=>'100',
                ],
                'label'=>false,
                'label_attr'=>[
                    'class' =>'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min'=> 2 , 'max'=>100])
                ]
            ])
            ->add('message', TextareaType::class,[
                'attr' => [
                    'class' =>'form-control'
                ],
                'label'=>false,
                'label_attr'=>[
                    'class' =>'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('envoyer', SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'Envoyer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
