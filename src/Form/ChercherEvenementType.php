<?php

namespace App\Form;
use App\Entity\LieuEvenement;
use App\Repository\EvenementRepository;
use App\Repository\LieuEvenementRepository;
use App\Repository\TypeEvenementRepository;
use App\Service\TypeEvenementService;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ChercherEvenementType extends AbstractType
{
    /**
     * @var TypeEvenementRepository
     */
    private $typeEvenementRepository;
    /**
     * @var TypeEvenementService
     */
    private $typeEvenementService;
    /**
     * @var LieuEvenementRepository
     */
    private $lieuEvenementRepository;
    function __construct(LieuEvenementRepository $lieuEvenementRepository,TypeEvenementRepository $typeEvenementRepository,TypeEvenementService $typeEvenementService)
    {
        $this->typeEvenementRepository = $typeEvenementRepository;
        $this->typeEvenementService = $typeEvenementService;
        $this->lieuEvenementRepository = $lieuEvenementRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $listeTypeEvenement = $this->typeEvenementRepository->findAll();
        try {
            $typeEvenementPourFormulaire = $this->typeEvenementService->cleValeurTypeEvenement($listeTypeEvenement, 'getType');
        } catch (\ReflectionException $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n"; die();
        }
        $lieuEvenement = $this->lieuEvenementRepository->findAll();
        try {
            $lieuEvenementPourFormulaire = $this->typeEvenementService->cleValeurTypeEvenement($lieuEvenement, 'getNomLieuEvenement');
        } catch (\ReflectionException $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n"; die();
        }


        $builder
            ->add('date_evenement_debut',DateType::class,[
                'attr' => ['class' => 'js_datepicker1'],
                'html5' => false,
                'widget' => 'single_text',
                'required' => false

            ])
            ->add('date_evenement_fin',DateType::class,[
                'attr' => ['class' => 'js_datepicker2'],
                'html5' => false,
                'widget' => 'single_text',
                'required' => false

            ])
            ->add('type_evenement',ChoiceType::class,[
                'multiple' => true,
                'attr'=>['class' => 'type_evenement'],
                'choices' => $typeEvenementPourFormulaire,
                'required' => false
            ])
            ->add('budget_evenement_min',TextType::class,[
                'required' => false
            ])
            ->add('budget_evenement_max',TextType::class,[
                'required' => false
            ])
            ->add('lieu_evenement',ChoiceType::class,[
                'multiple' => true,
                'choices' => $lieuEvenementPourFormulaire,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
