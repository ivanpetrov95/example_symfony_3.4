<?php

namespace ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->
        add('email', EmailType::class)
        ->add('password', RepeatedType::class,[
            'type' => PasswordType::class,
            'invalid_message' => 'The password fields must match.',
            'options' => ['attr' => ['class' => 'password-field']],
            'required' => true,
            'first_options' => ['label' => 'Password'],
            'second_options' => ['label' => 'Confirm Password'],
        ])
        ->add('username', TextType::class)
        ->add("pictureURI", FileType::class, [
            "required" => false,
            "data_class" => null,
            "empty_data" => null
        ])
        ->add('submit', SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ShopBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'shopbundle_user';
    }


}
