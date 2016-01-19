<?php
namespace AppBundle\Form;

use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\CallbackTransformer;

class RegistrationType extends BaseType
{
public function buildForm(FormBuilderInterface $builder,
array $options)
{
    parent::buildForm($builder, $options);
    $builder
        ->add($builder->create('telephone','text')
            ->addModelTransformer(
                new CallbackTransformer(
                    function ($originalDescription) {
                        return preg_replace("/[0-9]{2}/", "$0 ", $originalDescription);
                    },
                    function ($submittedDescription) {
                        return preg_replace('/[-. ]/', "",$submittedDescription);
                    }
                )
            ));



}

public function getName()
{
return 'appbundle_user_registration';
}
}