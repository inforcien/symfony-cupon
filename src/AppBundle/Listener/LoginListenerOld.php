<?php

namespace AppBundle\Listener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Listener del evento SecurityInteractive que se utiliza para redireccionar
 * al usuario recién logueado a la portada de su ciudad.
 */
class LoginListener
{
    private $router, $ciudad = null;

    public function __construct( Router $router)
    {
        $this->router = $router;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $token = $event->getAuthenticationToken();
        $this->ciudad = $token->getUser()->getCiudad()->getSlug();
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (null === $this->ciudad) {
            return;
        }
            
        $urlPportada = $this->router->generate('portada', array('ciudad' => $this->ciudad));
 
        $event->setResponse(new RedirectResponse($urlPportada));
        $event->stopPropagation();
    }
}
