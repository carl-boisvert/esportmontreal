<?php

namespace EsportBundle\Form;

use Doctrine\ORM\EntityManager;
use EsportBundle\Entity\Player;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Psr\Log\LoggerInterface;

class PlayerType extends AbstractType
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

        /**
         * Fetch Countries from the database to populate the select box
         */
        $stmt = $this->em
            ->getConnection()
            ->prepare('select id,country from regions');
        $stmt->execute();
        $country = $stmt->fetchAll();
        $countries = array();
        foreach( $country as $c){
            $countries[$c['id']] = $c['country'];
        }


        /**
         * Add the fields to the form
         */

        $builder
            ->add('gamertag','text')
            ->add('console','choice',array(
                    'choices' => array(
                        'PS4'=>'PS4',
                        'Xbox One'=>'Xbox One',
                        'PC'    => 'PC'
                    ),
                    'label'=>"Competition plateform",
                    'required'=>true,
                    'empty_value' => 'Select'
                ))
            ->add('firstname','text')
            ->add('lastname','text')
            ->add('email','email')
            ->add('password','repeated', array(
                'type' => 'password',
                'invalid_message' => 'The password fields must match.',
                'required' => true,
                'first_options'  => array(
                    'label' => 'Password',
                    "attr"=>array(
                        "class"=>"form-control"
                    )),
                'second_options' => array('label' => 'Repeat Password',"attr"=>array(
                    "class"=>"form-control"
                ))))
            ->add('country', 'choice', array(
                    'choices'   => $countries,
                    'required'  => true,
                    'empty_value' => 'Select'
                ))
            ->add('region','choice',array(
                    'choices' => array(),
                    'required'=>true,
                    'empty_value' => 'Select',
                ))
            ->add('save', 'submit', array('label' => 'Subscribe'));

        $formModifier = function (FormInterface $form, $id) {
            $stmt = $this->em
                ->getConnection()
                ->prepare('select id,name from subregions where region_id = :p');
            $stmt->bindParam(':p',$id);
            $stmt->execute();
            $region = $stmt->fetchAll();
            $regions = array();
            foreach( $region as $c){
                $regions[$c['id']] = $c['name'];
            }
            $form->add('region','choice',array(
                    'choices' => $regions,
                    'required'=>true,
                    'empty_value' => '',
                ));
        };

        $builder->get('country')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $player = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $player);
            }
        );
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
        return 'esportbundle_player';
    }
}
