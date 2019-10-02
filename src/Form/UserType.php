<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\IsTrue;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
              ->add('email', EmailType::class)
              ->add(
                  'password',
                  RepeatedType::class,
                  array('type' => PasswordType::class,
                      'first_options' => array('label' => 'Mot de passe'),
                      'second_options' => array('label' => 'Confirmation du mot de passe'),
                  )
              )
              ->add('agreeTerms', CheckboxType::class, [
                  'mapped' => false,
                  'label'=>"Accepter les condtions d'utilisation",
                  'constraints' => [
                      new IsTrue([
                          'message' => "Merci d'accepter les termes du site",
                      ]),
                  ],
              ])
              ->add('submit', SubmitType::class, ['label'=>'Envoyer', 'attr'=>['class'=>'btn-primary btn-block']])
      ;
    }
}
