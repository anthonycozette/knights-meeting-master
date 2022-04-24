<?php

namespace App\Form\FormExtension;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RepeatedPasswordType extends AbstractType
{
    public function getParent(): string{
        return RepeatedType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
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
}