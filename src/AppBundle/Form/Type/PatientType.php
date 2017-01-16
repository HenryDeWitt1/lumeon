<?php

namespace AppBundle\Form\Type;
use AppBundle\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


/**
 * Class PatientType
 * @package AppBundle\Form\Type
 */
class PatientType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Patient::class,
            'csrf_protection'   => false,
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('gender',ChoiceType::class,  [
                'choices' => [
                    'Male'=>1,
                    'Female'=>2,
                    'Other'=>3,
                ],
                'choices_as_values' => true,
            ])
            ->add('dob')
            ;
    }
}