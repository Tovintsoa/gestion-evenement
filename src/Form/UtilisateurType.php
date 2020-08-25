<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('mailUtilisateur',TextType::class,[
                'label' => 'Adresse e-mail'
            ])
            ->add('password',RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Répéter le mot de passe'],
            ])
            ->add('dateDeNaissanceUtilisateur',DateType::class,[
                'label' => 'Date de naissance',
                'attr' => ["class" => "js_datepickerNaissance"],
                'html5' => false,
                'widget' => 'single_text',
            ])
            ->add('adresseUtilisateur', TextType::class,[
                'label' => 'Adresse'
            ])
            ->add('nomUtilisateur',TextType::class,[
                'label' => 'Nom'
            ])
            ->add('prenomUtilisateur',TextType::class,[
                'label' => 'Prénom'
            ])
            ->add('loginUtilisateur',TextType::class,[
                'label' => 'Login'
            ])
            ->add('nomSociete',TextType::class,[
                'label' => 'Nom de votre société'
            ])
            ->add('nifSociete',TextType::class,[
                'label' => 'Nif'
            ])
            ->add('statSociete',TextType::class,[
                'label' => 'Stat'
            ])
            ->add('siegeSociete',TextType::class,[
                'label' => 'Adresse complete'
            ])
            /*->add('roles',ChoiceType::class,[
                'multiple' => true,
                'choices' =>[
                    'Utilisateur' => 'ROLE_USER',
                    'Préstataire évenementiel' => 'ROLE_PRESTATAIRE',
                ],
                'label' => "Vous êtes un "
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
