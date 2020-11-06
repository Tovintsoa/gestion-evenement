<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Repository\LieuEvenementRepository;
use App\Repository\TypeEvenementRepository;
use App\Service\TypeEvenementService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
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
            ->add('nomEvenement',TextType::class,[

            ])
            ->add('descriptionEvenement',TextType::class,[

            ])
            ->add('budgetEvenement',TextType::class,[

            ])
            ->add('dateDebutEvenement',DateType::class,[
                'attr' => ['class' => 'js_datepicker1'],
                'html5' => false,
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('dateFinEvenement',DateType::class,[
                'attr' => ['class' => 'js_datepicker2'],
                'html5' => false,
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('type_evenement',ChoiceType::class,[
                'mapped' => false,
                'multiple' => true,
                'attr'=>['class' => 'type_evenement'],
                'choices' => $typeEvenementPourFormulaire,
                'required' => false
            ])
            ->add('evenement_lieu_evenements',ChoiceType::class,[
                'mapped' => false,
                'multiple' => true,
                'choices' => $lieuEvenementPourFormulaire,
                'required' => false
            ])
            /*->add('createur_evenement_id')
            ->add('interesseEvenement')*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
