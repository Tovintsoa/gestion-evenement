<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Manager\UtilisateurManager;
use App\Repository\UtilisateurRepository;
use App\Service\SendMailService;
use App\Service\UtilisateurService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    private $urlGenerator;
    private $utilisateurRepository;
    private $utilisateurManager;
    private $sendMailService;
    function __construct(UtilisateurManager $utilisateurManager,UrlGeneratorInterface $urlGenerator,UtilisateurRepository $utilisateurRepository,SendMailService $sendMailService)
    {
        $this->utilisateurRepository = $utilisateurRepository;
        $this->urlGenerator = $urlGenerator;
        $this->utilisateurManager = $utilisateurManager;
        $this->sendMailService = $sendMailService;
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
            ->remove('prenomUtilisateur')
            ->remove('roles')
            ->remove('nomSociete')
            ->remove('nifSociete')
            ->remove('statSociete')
            ->remove('siegeSociete');
        $formUtilisateur->handleRequest($request);

        if ($formUtilisateur->isSubmitted() && $formUtilisateur->isValid()){

            $utilisateur->setActivationCompte(0);
            $utilisateur->setRoles(['ROLE_USER']);


            $this->utilisateurManager->create($utilisateur, $formUtilisateur->get('password')->getData());
            $this->utilisateurManager->save($utilisateur);

            $body = $this->renderView('layout/email/registration.html.twig',[
                "login" => $utilisateur->getLoginUtilisateur(),
                "email" => $utilisateur->getMailUtilisateur(),
                'token' => $utilisateur->getToken()
            ]);
            $mailSended = $this->sendMailService->send($utilisateur->getMailUtilisateur(),"Validation de votre compte",$body);
            return $this->render('security/mailSend.html.twig',[
                "login" => $utilisateur->getLoginUtilisateur(),
                "email" => $utilisateur->getMailUtilisateur(),

            ]);
        }
        return $this->render('security/createAccount.html.twig',[
            'controller' => "security",
            "form" => $formUtilisateur->createView()
        ]);
    }

    /**
     * @Route("/verifier_mon_compte", name="app_verifyAccount")
     */
    public function verifyAccount(){
        $utilisateur = $this->getUser();
        $this->utilisateurManager->setToken($utilisateur);
        $this->utilisateurManager->save($utilisateur);
        //dd($utilisateur);
        $body = $this->renderView('layout/email/registration.html.twig',[
            "login" => $utilisateur->getLoginUtilisateur(),
            "email" => $utilisateur->getMailUtilisateur(),
            'token' => $utilisateur->getToken()
        ]);
        $mailSended = $this->sendMailService->send($utilisateur->getMailUtilisateur(),"Validation de votre compte",$body);
        return $this->render('security/mailSend.html.twig',[
            "login" => $utilisateur->getLoginUtilisateur(),
            "email" => $utilisateur->getMailUtilisateur(),

        ]);
    }

    /**
     * @Route("/validation/{token}",name="app_validate_account")
     */
    public function valide_compte(UtilisateurManager $utilisateurManager,AuthenticationUtils $authenticationUtils,$token = null){
        $user = $utilisateurManager->findBy(['token' => $token]);

        if($user instanceof Utilisateur && $user->getTokenExpiredAt() > new \DateTime('now')){
            $utilisateurManager->activate($user);
            $token = new UsernamePasswordToken($user,null,'main',$user->getRoles());
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));
            $this->addFlash('success', 'Votre compte a ??t?? valid?? avec succ??s !');
            return $this->login($authenticationUtils);
        }
        else {
            $this->addFlash('danger', 'La cl?? de confirmation de l\'inscription a expir??');
        }
        return $this->login($authenticationUtils);
    }

    /**
     * @Route("/creer_compte_professionnel",name="app_create_pro_account")
     */
    public function createAccountPro(Request $request){
        if ($this->getUser()) {
            return $this->redirectToRoute('accueil');
        }
        $utilisateur = new Utilisateur();
        $formUtilisateur = $this->createForm(UtilisateurType::class, $utilisateur,[
            'method' => 'POST',
        ])->remove('dateDeNaissanceUtilisateur')
            ->remove('adresseUtilisateur')
            ->remove('nomUtilisateur')
            ->remove('prenomUtilisateur')
            ->remove('roles')
            ->remove("loginUtilisateur");
        $formUtilisateur->handleRequest($request);
        if ($formUtilisateur->isSubmitted() && $formUtilisateur->isValid()){

            $utilisateur->setLoginUtilisateur($request->request->get("utilisateur")['nomSociete']);
            $utilisateur->setRoles(['ROLE_PRESTATAIRE']);
            $utilisateur->setActivationCompte(0);
            $this->utilisateurManager->create($utilisateur, $formUtilisateur->get('password')->getData());

            $this->utilisateurManager->save($utilisateur);
        }
        return $this->render('security/createAccountPro.html.twig',[
            'controller' => "security",
            "form" => $formUtilisateur->createView()
        ]);
    }
}
