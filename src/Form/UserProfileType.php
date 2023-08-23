<?php

namespace App\Form;

use App\Entity\UserData;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $year = (new DateTime())->format('Y');
        $builder
                ->add('first_name', TextType::class, [
                    'label' => 'First Name',
                    'required' => true,
                ])
                ->add('last_name', TextType::class, [
                    'label' => 'Last Name',
                    'required' => true,
                ])
                ->add('address', TextType::class, [
                    'label' => 'Address',
                    'required' => false,
                ])
                ->add('birth_date', DateType::class, [
                    'label' => 'Date of Birth',
                    'required' => false,
                    'years' => range($year-100, $year)
                ])
                ->add('about', TextareaType::class, [
                    'label' => 'Briefly about yourself',
                    'required' => false,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserData::class,
        ]);
    }

}
