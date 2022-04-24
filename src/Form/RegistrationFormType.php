<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use App\Form\FormExtension\RepeatedPasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => "Email",
                'attr' => [
                    'placeholder' => 'Votre email'
                ]
            ])

            ->add('pseudo', TextType::class,[
                "label" => 'Pseudo',
                "attr" => [
                    'placeholder' => 'Votre pseudo'
                ],
                "constraints" => [
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Votre pseudo doir contenir au moin 4 caracteres.'
                    ]),
                ],
            ])

            ->add('agreeTerms', CheckboxType::class, [
                'label' => "J'accepte les conditions d'utilisation de ce site.",
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new IsTrue([
                        'message' => "vous devez accepter les conditions d'utilisation de ce site pour vous inscrire. ",
                    ]),
                ],
            ])

            ->add('password', RepeatedType::class,[
                'type' => PasswordType::class,
            'mapped' =>false,
            'attr' => ['autocomplete'=> 'new-password'],
            'invalid_message' => "les mot de passe saisis ne correspondent pas.",
            // 'required' => true,
            'first_options' => [
                'label' => "Mot de passe",
                'attr' => ['placeholder' => 'Entrez un mot de passe'
                ],
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moin 6 caractères'
                    ]),
                    new NotBlank([
                        'message' => 'Vous devez entrer un mot de passe'
                    ]),
                ]
                
            ],
            'second_options' => [
                'label' => "Confirmer le mot de passe",
                'attr' => ['placeholder' => 'Confirmer le mot de passe'
                ],
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moin 6 caractères'
                    ]),
                    new NotBlank([
                        'message' => 'Vous devez entrer un mot de passe'
                    ]),
                ]
            ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
