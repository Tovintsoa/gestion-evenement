<?php
namespace  App\Manager;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class UtilisateurManager{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var TokenGeneratorInterface
     */
    private $tokenGenerator;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UtilisateurRepository
     */
    private $repository;

    function __construct(EntityManagerInterface $entityManager, TokenGeneratorInterface $tokenGenerator, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Utilisateur::class);
        $this->passwordEncoder = $passwordEncoder;
        $this->tokenGenerator = $tokenGenerator;
    }
    public function create(Utilisateur $user, $plainPassword = null)
    {
        $this->setPassword($user, $plainPassword);
       // $this->setRoles(['ROLE_USER']);
        /**
         * Generate and save token
         */


    }
    public function save(Utilisateur $user)
    {

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
    public function setPassword(Utilisateur $user, $plainPassword): void
    {
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                $plainPassword
            )
        );
    }

    private function emailExist(string $email)
    {
        return $this->entityManager->getRepository(Utilisateur::class)->findOneBy(['mailUtilisateur' => $email]);
    }

}