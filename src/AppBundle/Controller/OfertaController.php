<?php


namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

class OfertaController extends Controller
{
    /**
     * @Route("/{ciudad}/ofertas/{slug}", name="oferta")
     *
     * Muestra la página de detalle de la oferta indicada.
     *
     * @param string $ciudad El slug de la ciudad a la que pertenece la oferta
     * @param string $slug   El slug de la oferta (es único en cada ciudad)
     *
     * @return Response
     *
     * @throws NotFoundHttpException
     */
    public function ofertaAction($ciudad, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $oferta = $em->getRepository('AppBundle:Oferta')->findOferta($ciudad, $slug);
        $relacionadas = $em->getRepository('AppBundle:Oferta')->findRelacionadas($ciudad);

        if (!$oferta) {
            throw $this->createNotFoundException('No se ha encontrado la oferta solicitada');
        }

        return $this->render('oferta/detalle.html.twig', array(
            'oferta' => $oferta,
            'relacionadas' => $relacionadas,
        ));
    }
}
