<?php

namespace App\Controller;
use App\Entity\Evenement;
use App\Entity\Utilisateur;
use App\Form\ChercherEvenementType;
use App\Manager\UtilisateurManager;
use App\Repository\EvenementRepository;
use App\Repository\TypeEvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    private $utilisateurManager;

    public function __construct(UtilisateurManager $utilisateurManager,EvenementRepository $evenementRepository,TypeEvenementRepository $typeEvenementRepository)
    {
        $this->utilisateurManager = $utilisateurManager;
        $this->evenementRepository = $evenementRepository;
        $this->typeEvenementRepository = $typeEvenementRepository;
    }


    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(Request $request,PaginatorInterface $paginator)
    {
        $formChercherEvenement = $this->createForm(ChercherEvenementType::class, null,[
            'method' => 'GET',
        ]);
        $formChercherEvenement->handleRequest($request);

        if ($formChercherEvenement->isSubmitted()) {
            $res = $this->evenementRepository->chercherEvenement($request->query->get("chercher_evenement"));

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

    /**
     * @Route("/interesse/{user}/{evenement}", name="interesse",options={"expose"=true})
     */
    public function interesseEvenement(Utilisateur $user,Evenement $evenement){
        $user->addInteresseEvnement($evenement);
        $this->utilisateurManager->save($user);
        return new Response("true");
    }
    public function afficherInteresseEvenement(Utilisateur $user,Evenement $evenement){
      $allUserInteressted = $user->getInteresseEvnements();

    }
}
