<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    
    /**
     * @Route("/sitio/{nombrePagina}", defaults={ "nombrePagina"="ayuda" }, name="pagina")
     */
    public function paginaAction($nombrePagina, Request $request)
    {
        return $this->render(sprintf('sitio/%s/%s.html.twig', $request->getLocale(), $nombrePagina));

//        return $this->render('sitio/'.$nombrePagina.'.html.twig');
    } 
    
    
    /**
     * @Route("/{ciudad}", defaults={ "ciudad" = "%app.ciudad_por_defecto%" }, name="portada")
     * @Route("/")
     *
     * Muestra la portada del sitio web.
     *
     * @param string $ciudad El slug de la ciudad activa en la aplicación
     *
     * @return Response
     *
     * @throws NotFoundHttpException
     */
    public function portadaAction($ciudad, Request $request)
    {
 
        if (null === $ciudad) { 
            return $this->redirectToRoute('portada', array( 'ciudad' => $this->getParameter('app.ciudad_por_defecto') )); 
            
        } 
        $em = $this->getDoctrine()->getManager();
        $oferta = $em->getRepository('AppBundle:Oferta')->findOfertaDelDia($ciudad);

        if (!$oferta) {
            throw $this->createNotFoundException('No se ha encontrado ninguna oferta del día en la ciudad seleccionada');
        }

        return $this->render('portada.html.twig', array(
            'oferta' => $oferta,
        ));
    }

    
    /**
     * @Route("/pruebas/{ciudad}", name="pruebas")
     */
    public function pruebasAction($ciudad, Request $request)
    {
        //        localhost:8000/app_dev.php?XDEBUG_SESSION_START=netbeans-xdebug
        
        // aquí ya está disponible la variable $request
        // con toda la información de la petición del usuario

        // Obtener el valor del parámetro GET llamado 'ciudad'
        // $ciudad valdrá 'null' si no existe el parámetro 'ciudad'

        $ciudad = $request->query->get('ciudad');
        // Mismo ejemplo, pero asignando un valor por defecto por si
        // no existe el parámetro de tipo GET llamado 'ciudad'
        $ciudad = $request->query->get('ciudad', 'paris');

        // Obtener el valor del parámetro POST llamado 'ciudad'
        // $ciudad valdrá 'null' si no existe el parámetro 'ciudad'
        $ciudad = $request->request->get('ciudad');

        // Mismo ejemplo, pero asignando un valor por defecto por si
        // no existe el parámetro de tipo POST llamado 'ciudad'
        $ciudad = $request->request->get('ciudad', 'paris');

        // Saber qué navegador utiliza el usuario mediante la cabecera HTTP_USER_AGENT
        $navegador = $request->server->get('HTTP_USER_AGENT');

        // Mismo ejemplo, pero más fácil directamente a través de las cabeceras
        $navegador = $request->headers->get('user-agent');

        // Obtener el nombre de todas las cabeceras enviadas
        $cabeceras = $request->headers->keys();
        
         // Obtener array con todos los parametros
        $cabeceras = $request->headers->all();

        // Saber si se ha enviado una cookie de sesión
        $hayCookieSesion = $request->cookies->has('PHPSESSID');
        
        // La clase Request también incluye un método llamado get() que obtiene
        //  el valor del parámetro cuyo nombre se indica como argumento. Este
        //   parámetro se busca, por este orden, en las variables
        //$_GET, $_SERVER['PATH_INFO'], y $_POST:

        $ciudad2 = $request->get('ciudad');
        
//        Devuelve el nombre en mayúsculas del método utilizado para la petición (GET, POST, PUT, DELETE). 
        $metod = $request->getMethod();

//        Devuelve la URI de la petición. Ejemplo: /madrid
        $uri = $request->getRequestUri();
        
//        Devuelve el esquema utilizado (http o https)
        $scheme = $request->getScheme();
                
//        Devuelve el host de la URI. Ejemplo: cupon.local localhost
        $host = $request->getHost();         

//        Devuelve la dirección IP del usuario que ha realizado la petición. Si el usuario se encuentra detrás de un proxy, busca su dirección en los parámetros
        $ip = $request->getClientIp();
        
//        Devuelve un array con el código de los idiomas preferidos por el usuario y ordenados por importancia
        $idioma =  $request->getLanguages();
        
//        Devuelve el formato de la petición en minúsculas
        $format =  $request->getRequestFormat();
        
        
        

        
        
    } 
    
    
}
