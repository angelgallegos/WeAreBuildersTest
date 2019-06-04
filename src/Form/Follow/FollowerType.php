<?php


namespace App\Form\Follow;


use App\Entity\Follow\Follower;
use App\Entity\User\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FollowerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user_one', EntityType::class, [
                'class' => User::class,
                'property_path' => 'userOne'
            ])
            ->add('user_two', EntityType::class, [
                'class' => User::class,
                'property_path' => 'userTwo'
            ])
            ->add('status')
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Follower::class,
            'csrf_protection' => false
        ));
    }
}