<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para crear entidades de tipo Usuario cuando los usuarios se
 * registran en el sitio.
 * Como se utiliza en la parte pública del sitio, algunas propiedades de
 * la entidad no se incluyen en el formulario.
 */
class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apellidos')
            ->add('email', 'email')
                
            ->add('password', 'repeated', array( 
                'type' => 'password',
                'invalid_message' => 'Las dos contraseñas deben coincidir',
                'first_options'	=> array('label' => 'Contraseña'),
                'second_options' => array('label' => 'Repite Contraseña'),
            ))

            ->add('direccion')
            ->add('permiteEmail')
            ->add('fechaNacimiento', 'birthday')
            ->add('dni')
            ->add('numeroTarjeta')
            ->add('ciudad')
//            ->add('registrame','submit')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Usuario',
        ));
    }

    public function getBlockPrefix()
    {
        return 'usuario';
    }
}
