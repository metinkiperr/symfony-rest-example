<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Class AppointmentType
 * @package AppBundle\Form
 */
class AppointmentType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('appointment_date', DateTimeType::class, array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy HH:mm:ss',
                'input'  => 'datetime'
            ))
            ->add('appointment_notes', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Appointment',
            'csrf_protection' => false,
        ]);

    }
}