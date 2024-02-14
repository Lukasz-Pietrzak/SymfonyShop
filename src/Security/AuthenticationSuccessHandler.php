<?php
// src/Security/Authentication/AuthenticationSuccessHandler.php
namespace App\Security;

use App\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private $urlGenerator;
    private $router;
    private $authorizationChecker;

    public function __construct(RouterInterface $router, AuthorizationCheckerInterface $authorizationChecker, UrlGeneratorInterface $urlGenerator)
    {
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
        $this->urlGenerator = $urlGenerator;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): Response
    {

        if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            // Jeśli użytkownik ma rolę admina, przekieruj go gdzie indziej
            return new RedirectResponse($this->urlGenerator->generate('ui_home'));
        }
        // Retrieve the authenticated user from the security token
        $user = $token->getUser();

        // Redirect to ui_home route
        $url = $this->router->generate('ui_home');

        // Check if the user is an instance of the expected class (e.g., User)
        if (!$user instanceof User) {
            throw new \LogicException('User object is not an instance of the expected class.');
        }

        $orders = $user->getOrders();

        // Calculate the total number of orders
        $amountOrder = count($orders);

        // Generate the JavaScript code
        $jsCode = "<script>localStorage.setItem('cartIconCounter', $amountOrder);</script>";

        // Return JavaScript and redirect response
        $response = new Response($jsCode);
        $response->headers->set('Refresh', '0; url=' . $url);

        return $response;
    }
}
