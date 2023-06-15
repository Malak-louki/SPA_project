<?php

namespace App\Controller\Admin;

use App\Entity\Announcer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class AnnouncerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Announcer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Administration des annonceurs')
            ->setEntityLabelInSingular('Annonceur')
            ->setEntityLabelInPlural('Annonceurs')
            ->setPaginatorPageSize(30)
            ->setPaginatorRangeSize(3);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setFormTypeOption('disabled', 'disabled'),
            TextField::new('firstName', "Prénom"),
            TextField::new('lastName', "Nom"),
            TextField::new('email', "e-Mail"),
            TextField::new('plainPassword', "Nouveau mot de passe")->onlyOnForms(),
            TextField::new('city', "Ville"),
            AssociationField::new('department', "Département"),
        ];
    }
}