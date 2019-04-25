<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\TextType;
use Symfony\Component\Form\Extension\Core\PasswordType;
use Symfony\Component\Form\Extension\Core\EmailType;
use Symfony\Component\Form\Extension\Core\TextareaType;
use Symfony\Component\Form\Extension\Core\DateType;
use Symfony\Component\Form\Extension\Core\IntegerType;
use Symfony\Component\Form\Extension\Core\SubmitType;
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class)
            ->add('email',EmailType::class)
            ->add('pwd',PasswordType::class)
            ->add('bday',DateType::class)
            ->add('phone',IntegerType::class)
            //->add('bio',TextareaType::class)
            //->add('profile_pic',TextType::class)
            ->add('save',SubmitType::class,['label' => 'Subscribe !'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
