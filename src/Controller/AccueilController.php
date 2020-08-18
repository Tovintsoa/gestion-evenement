<?php

namespace App\Controller;
use App\Form\ChercherEvenementType;
use App\Repository\EvenementRepository;
use App\Repository\TypeEvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class AccueilController extends AbstractController
{
    /**
     * @var EvenementRepository
     */
    private $evenementRepository;
    /**
     * @var TypeEvenementRepository
     */
    private $typeEvenementRepository;
    public function __construct(EvenementRepository $evenementRepository,TypeEvenementRepository $typeEvenementRepository)
    {
        $this->evenementRepository = $evenementRepository;
        $this->typeEvenementRepository = $typeEvenementRepository;
    }


    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(Request $request,PaginatorInterface $paginator)
    {
        $formChercherEvenement = $this->createForm(ChercherEvenementType::class, null);
        $formChercherEvenement->handleRequest($request);

        if ($formChercherEvenement->isSubmitted()) {
            $res = $this->evenementRepository->chercherEvenement($request->request->get("chercher_evenement"));

            $resultat = $paginator->paginate(
                $res, // Requête contenant les données à paginer (ici nos articles)
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                10 // Nombre de résultats par page
            );
            return $this->render('accueil/resultatRecherche.html.twig',[
                'formChercherEvenement' => $formChercherEvenement->createView(),
                "resultat_recherche" => $resultat,
            ]);
        }
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'formChercherEvenement' => $formChercherEvenement->createView()
        ]);
    }
    public function afficherTypeEvenement($id_type){
        $typeEvenement = $this->typeEvenementRepository->find($id_type);
        return $this->render('accueil/resultatRecherche/afficherType.html.twig', [
            'typeEvenement' => $typeEvenement,
        ]);
    }
}
