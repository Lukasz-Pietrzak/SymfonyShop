<?php 
// src/EventListener/LogoutSubscriber.php
namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class LogoutSubscriber implements EventSubscriberInterface
{
    private UrlGeneratorInterface $urlGenerator;
    private RequestStack $requestStack;

    public function __construct(UrlGeneratorInterface $urlGenerator, RequestStack $requestStack)
    {
        $this->urlGenerator = $urlGenerator;
        $this->requestStack = $requestStack;
    }

    public static function getSubscribedEvents(): array
    {
        return [LogoutEvent::class => 'onLogout'];
    }

    public function onLogout(LogoutEvent $event): void
    {
        // Create JavaScript code to set localStorage variable
        $jsCode = '<script>localStorage.setItem("cartIconCounter", 0);</script>';
    
        // Create a new Response object with JavaScript code
        $response = new Response($jsCode);
    
        // Prepare the response to ensure content is rendered
        $response->prepare($event->getRequest());
    
        // Create a new RedirectResponse
        $redirectResponse = new RedirectResponse(
            $this->urlGenerator->generate('ui_home'),
            RedirectResponse::HTTP_SEE_OTHER
        );
    
        // Merge content of $response and $redirectResponse
        $response->setContent($response->getContent() . $redirectResponse->getContent());
    
        // Set the merged response to the event
        $event->setResponse($response);
    }
}
