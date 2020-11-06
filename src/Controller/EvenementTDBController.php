<?php


namespace App\Controller;


use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EvenementTDBController  extends AbstractController
{
    private $evenementRepository;
    public function __construct(EvenementRepository $evenementRepository)
    {
        $this->evenementRepository = $evenementRepository;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/espace-admin/evenement", name="evenement_liste")
     */
    public function listeEvenement(){
        $listeEvenement = $this->evenementRepository->findBy(["createur_evenement_id" => $this->getUser()->getId()]);
         return $this->render("tdb/evenement/liste-evenement.html.twig",[
             "liste_evenement" => $listeEvenement
         ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/espace-admin/evenement/ajouter" , name="ajouter-evenement")
     */
    public function creerEvenement(){
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class,$evenement);
        return $this->render('tdb/evenement/ajouter-evenement.html.twig',[
            "form_evenement" => $form->createView()
        ]);
    }
}