<?php

namespace CSGOTalk\siteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use CSGOTalk\siteBundle\Form\TeamType;

use CSGOTalk\siteBundle\Entity\Team;

class MatchsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('getTeamId1', new TeamType)
            ->add('save',      'submit')
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