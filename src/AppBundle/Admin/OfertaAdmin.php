<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class OfertaAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombre')
            ->add('descripcion')
            ->add('ciudad')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('revisada', null, array('editable' => true, 'label' => 'Revisada'))
            ->addIdentifier('nombre', null, array('label' => 'Título'))
            ->add('foto', NULL, array(
                'template' => 'AppBundle:AdminOferta:plantilla_imagen.html.twig'))

            ->add('tienda')
            ->add('ciudad')
            ->add('precio')
            ->add('compras')
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $options = array('required' => false);
        if (($subject = $this->getSubject()) && $subject->getFoto()){
            $path = $subject->getImagenWebPath();
            $options['help'] = '<img src="'.$path.'">';
        }

        
        $formMapper
            ->add('nombre', null, array("read_only" => true))
            ->add('slug', null, array('required' => false))
            ->add('descripcion')
            ->add('condiciones')
            ->add('fecha_publicacion', 'datetime')
            ->add('fecha_expiracion', 'datetime')
            ->add('revisada')
            ->add('foto','file', $options)
            ->add('precio')
            ->add('descuento')
            ->add('compras')
            ->add('umbral')
            ->add('tienda')
            ->add('ciudad')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('nombre')
            ->add('slug')
            ->add('descripcion')
            ->add('condiciones')
            ->add('fecha_publicacion', 'datetime')
            ->add('fecha_expiracion', 'datetime')
            ->add('revisada')
            ->add('rutaFoto')
            ->add('precio')
            ->add('descuento')
            ->add('compras')
            ->add('umbral')
            ->add('tienda')
            ->add('ciudad')
        ;
    }
    
    
    public function getNewInstance()
    {
        $oferta = parent::getNewInstance();
        $oferta->setRevisada(true);

        $fecha = new \DateTime('now +1 days');
        $oferta->setFechaPublicacion($fecha);

        $fecha = new \DateTime('now +10 days');
        $oferta->setFechaExpiracion($fecha);
        
        return $oferta;
    }

    
}


