<?php

namespace PublicBundle\Form;

use Doctrine\ORM\EntityManager;
use Home\PublicBundle\Entity\Player;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Psr\Log\LoggerInterface;

class LoginType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /**
         * Add the fields to the form
         */

        $builder
            ->add('gamertag')
            ->add('password','password')
            ->add('save', 'submit', array('label' => 'Log in'));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'EsportBundle\Entity\Player'
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'esportbundle_login';
    }
}
