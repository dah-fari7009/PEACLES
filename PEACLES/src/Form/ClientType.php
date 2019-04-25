<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ClientType extends UserType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder,$options);
        $builder
            ->add('bday',DateType::class,['label' => 'Your Birthday : ',
            'constraints' => [
                new LessThan('today')
            ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }

}
?>