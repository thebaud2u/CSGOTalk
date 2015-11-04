<?php

namespace CSGOTalk\siteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use CSGOTalk\siteBundle\Entity\Map;

class MapType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'entity', array(
                  'class'    => 'CSGOTalksiteBundle:Map',
                  'property' => 'getName',
                  'multiple' => false,
                  'label' => 'Maps'
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CSGOTalk\siteBundle\Entity\Map'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'csgotalk_sitebundle_map';
    }
}
