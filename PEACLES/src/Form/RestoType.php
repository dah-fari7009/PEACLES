<?php
namespace App\Form;

use App\Entity\Restaurant;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class RestoType extends UserType{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder,$options);
        $builder
            ->add('address',TextType::class,['label' => 'Your Adress : '])
            ->add('min_seats', IntegerType::class, ['label' => 'Min seats'])
            ->add('max_seats', IntegerType::class, ['label' => 'Max seats'])
            ->add('min_age', IntegerType::class, ['label' => 'Age restriction'])
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
