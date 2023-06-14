<?php

namespace App\Controller\Admin;

use App\Entity\Adopter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdopterCrudController extends AbstractCrudController
{
    public function __construct(
        protected UserPasswordHasherInterface $passwordHasher
    ) {
    }


    public static function getEntityFqcn(): string
    {
        return Adopter::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Administration des adoptants')
            ->setEntityLabelInSingular('Adoptant')
            ->setEntityLabelInPlural('Adoptants')
            // ->setPaginatorPageSize(30)
            // ->setPaginatorRangeSize(3)
        ;
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            IdField::new('id')->setFormTypeOption('disabled', 'disabled'),
            TextField::new('firstName', "Prénom"),
            TextField::new('lastName', "Nom"),
            TextField::new('tel', "Téléphone"),
            TextField::new('email', "e-Mail"),
            TextField::new('password', "Mot de passe")->hideOnIndex()->setFormType(PasswordType::class),
            TextField::new('city', "Ville"),
            // Field::new('department'),
        ];
    }

}