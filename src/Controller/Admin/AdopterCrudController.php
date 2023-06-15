<?php

namespace App\Controller\Admin;

use App\Entity\Adopter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class AdopterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Adopter::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Administration des adoptants')
            ->setEntityLabelInSingular('Adoptant')
            ->setEntityLabelInPlural('Adoptants');
    }

    public function configureActions(Actions $actions): Actions
    {
        // Ajout bouton "consultation" d'un adoptant
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER);
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            IdField::new('id')->setFormTypeOption('disabled', 'disabled'),
            TextField::new('firstName', "Prénom"),
            TextField::new('lastName', "Nom"),
            TextField::new('tel', "Téléphone"),
            TextField::new('email', "e-Mail"),
            TextField::new('plainPassword', "Nouveau mot de passe")->onlyOnForms(),
            TextField::new('city', "Ville"),
            AssociationField::new('department', "Département"),
        ];
    }

}