<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class,['label' => 'Your Name : ',
            'constraints' => [
                new Length([
                    'min'=> 1,
                    'minMessage' => "I hope you're not as short as your name !",
                    'max' => 50,
                    'maxMessage' => "Did your cat just walk on the keyboard ?!"
                ]),
            ]])
            ->add('email',EmailType::class,['label' => 'Your Email : '])
            ->add('password',PasswordType::class,['label' => 'Choose a Password : ',
            'constraints' => [
                new Length([
                    'min'=> 8,
                    'minMessage' => "Is that all you got ?",
                    'max' => 50,
                    'maxMessage' => "Ah, that's a long one !"
                ]),
            ]])
            //->add('rpwd',PasswordType::class,['label' => 'Confirm your Password : ']),
            ->add('phone',IntegerType::class,['label' => 'Your Phone Number : '])
            ->add('bio',TextareaType::class, [
              'label' => 'Bio',
              'constraints' => [
                new Length([
                  'max' => 200,
                  'maxMessage' => "Bio must be  shorter than 200 characters"
                ]),
              ]
            ])
            ->add('profile_pic',FileType::class, [
              'label'=> 'Picture : ',
              'mapped'=> 'false'
          ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
