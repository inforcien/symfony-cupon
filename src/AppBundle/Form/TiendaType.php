<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TiendaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('login', 'text', array('read_only' => true))

            ->add('passwordEnClaro', 'repeated', array( 
                'type' => 'password',
                'invalid_message'=> 'Las dos contraseñas deben coincidir', 
                'first_options'	 => array('label' => 'Contraseña'), 
                'second_options' => array('label' => 'Repite Contraseña'),
                'required'	 => false
            ))

            ->add('descripcion')
            ->add('direccion')
            ->add('ciudad')
                
            ->add('guardar', 'submit', array('label' => 'Guardar cambios'))    
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Tienda'
        ));
    }
}
