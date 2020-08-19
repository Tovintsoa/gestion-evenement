<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Manager\UtilisateurManager;
use App\Repository\UtilisateurRepository;
use App\Service\UtilisateurService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private $urlGenerator;
    private $utilisateurRepository;
    private $utilisateurManager;
    function __construct(UtilisateurManager $utilisateurManager,UrlGeneratorInterface $urlGenerator,UtilisateurRepository $utilisateurRepository)
    {
        $this->utilisateurRepository = $utilisateurRepository;
        $this->urlGenerator = $urlGenerator;
        $this->utilisateurManager = $utilisateurManager;
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('accueil');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'controller' => "security"
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        return new RedirectResponse($this->urlGenerator->generate('accueil'));
    }

    /**
     * @Route("/creer_un_compte", name="app_createAccount")
     */
    public function createAccount(Request $request){
        if ($this->getUser()) {
            return $this->redirectToRoute('accueil');
        }
        $utilisateur = new Utilisateur();
        $formUtilisateur = $this->createForm(UtilisateurType::class, $utilisateur,[
            'method' => 'POST',
        ])->remove('dateDeNaissanceUtilisateur')
            ->remove('adresseUtilisateur')
            ->remove('nomUtilisateur')
            ->remove('prenomUtilisateur');
        $formUtilisateur->handleRequest($request);
        if ($formUtilisateur->isSubmitted() && $formUtilisateur->isValid()){
            //if($this->utilisateurManager->emailExist($formUtilisateur->get('mailUtilisateur')->getData()))
            $utilisateur->setRoles(['ROLE_USER']);
            $utilisateur->setActivationCompte(0);
            $this->utilisateurManager->create($utilisateur, $formUtilisateur->get('password')->getData());
            $this->utilisateurManager->save($utilisateur);
            return new RedirectResponse($this->urlGenerator->generate('app_login'));
        }
        return $this->render('security/createAccount.html.twig',[
            'controller' => "security",
            "form" => $formUtilisateur->createView()
        ]);
    }
}
