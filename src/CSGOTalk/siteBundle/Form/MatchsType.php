<?php

namespace CSGOTalk\siteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MatchsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('teamId1', 'entity', array(
            'class'    => 'CSGOTalksiteBundle:Team',
            'property' => 'name',
            'multiple' => false,
            'expanded' => false
          ))
            ->add('teamId2', 'entity', array(
            'class'    => 'CSGOTalksiteBundle:Team',
            'property' => 'name',
            'multiple' => false,
            'expanded' => false
          ))
            ->add('bestOfId', 'entity', array(
            'class'    => 'CSGOTalksiteBundle:BestOf',
            'property' => 'number',
            'multiple' => false,
            'expanded' => false
          ))
            ->add('map',        'text')
            ->add('save',       'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CSGOTalk\siteBundle\Entity\Matchs'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'csgotalk_sitebundle_matchs';
    }
}
