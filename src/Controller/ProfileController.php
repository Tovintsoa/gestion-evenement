<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Manager\UtilisateurManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProfileController extends AbstractController
{
    private $urlGenerator;
    private $utilisateurManager;
    function __construct(UrlGeneratorInterface $urlGenerator,UtilisateurManager $utilisateurManager)
    {
        $this->utilisateurManager = $utilisateurManager;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function index()
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    /**
     * @Route("/modifier_profile",name="modifierProfile")
     */
    public function modifierProfile(Request $request){
        $utilisateur = new Utilisateur();
        $formUtilisateur = $this->createForm(UtilisateurType::class, $utilisateur,[
            'method' => 'POST',
        ]);
        $formUtilisateur->handleRequest($request);
        if ($formUtilisateur->isSubmitted() && $formUtilisateur->isValid()){
            $this->utilisateurManager->create($utilisateur, $formUtilisateur->get('password')->getData());
            $this->utilisateurManager->save($utilisateur);
            return new RedirectResponse($this->urlGenerator->generate('profile'));
        }
        return $this->render('profile/modifier/index.html.twig',[
            "form" => $formUtilisateur->createView()
        ]);
    }
}
