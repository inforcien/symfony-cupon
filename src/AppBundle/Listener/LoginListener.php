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
    /** @var AuthorizationChecker */
    private $checker;
    /** @var Router */
    private $router;
    private $ciudad;

    public function __construct(AuthorizationChecker $checker, Router $router)
    {
        $this->checker = $checker;
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

        if ($this->checker->isGranted('ROLE_TIENDA')) {
            $urlPortada = $this->router->generate('extranet_portada');
        } else {
            $urlPortada = $this->router->generate('portada', array('ciudad' => $this->ciudad
            ));
        }

        $event->setResponse(new RedirectResponse($urlPortada));
        $event->stopPropagation();
    }
}
