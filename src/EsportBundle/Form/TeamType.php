<?php

namespace EsportBundle\Form;

use Doctrine\ORM\EntityManager;
use EsportBundle\Entity\Player;
use EsportBundle\Entity\Team;
use EsportBundle\Form\PlayerType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Psr\Log\LoggerInterface;

class TeamType extends AbstractType
{

    protected $em;
    protected $logger;

    public function __construct(EntityManager $em,LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name','text',array(
                'label'=>'Team name'
            ))
                ->add('players','collection',array(
                'required' => false,
                'type' => new PlayerType($this->em,$this->logger),
                'allow_add' => true,
                'allow_delete' => true ));

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'EsportBundle\Entity\Team'
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'esportbundle_team';
    }
}
