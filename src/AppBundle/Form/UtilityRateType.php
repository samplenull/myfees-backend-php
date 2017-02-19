<?php

namespace AppBundle\Form;

use AppBundle\Entity\Utility;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilityRateType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', null, [
                'widget' => 'single_text',
                'format' => Utility::DATE_FORMAT
            ])
            ->add('endDate', null, [
                'widget' => 'single_text',
                'format' => Utility::DATE_FORMAT
            ])
            ->add('value');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\UtilityRate'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'utilityrate';
    }


}
