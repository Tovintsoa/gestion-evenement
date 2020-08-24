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
        ])->remove("password")->remove("mailUtilisateur");
        $formUtilisateur->handleRequest($request);
        if ($formUtilisateur->isSubmitted() && $formUtilisateur->isValid()){
            $tableau = $request->request->get("utilisateur");

          /*  $this->utilisateurManager->create($utilisateur, $formUtilisateur->get('password')->getData());
            $this->utilisateurManager->save($utilisateur);*/
            $entityManager = $this->getDoctrine()->getManager();
            $utilisateur = $this->getUser();
            //dd($tableau["dateDeNaissanceUtilisateur"]);
            $dateNaissance = \DateTime::createFromFormat('Y-m-d', $tableau["dateDeNaissanceUtilisateur"]);
          // $dateNaissanceUtilisateur = $dateNaissance->format('Y-m-d H:i:s');
           // dd($dateNaissanceUtilisateur);date_create
           $utilisateur->setNomUtilisateur($tableau['nomUtilisateur'])
                       ->setPrenomUtilisateur($tableau['prenomUtilisateur'])
                       ->setAdresseUtilisateur($tableau['adresseUtilisateur'])
                       ->setDateDeNaissanceUtilisateur($dateNaissance)
                       ->setLoginUtilisateur($tableau['loginUtilisateur']);
            $entityManager->flush();



            return new RedirectResponse($this->urlGenerator->generate('profile'));
        }
        return $this->render('profile/modifier/index.html.twig',[
            "form" => $formUtilisateur->createView()
        ]);
    }
}
