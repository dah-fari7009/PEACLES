<?php
namespace App\Form;

use App\Entity\Restaurant;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RestoType extends UserType{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder,$options);
        $builder
            ->add('address',TextType::class,['label' => 'Your Adress : '])
            //age minimal et nombre de places à la suite
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
        ]);
    }
}
?>