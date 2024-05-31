<?php

namespace App\Form;

use App\Entity\Addresses;
use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

#[AsEntityAutocompleteField]
class AddressesAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Addresses::class,
            'placeholder' => 'Choose an Address',
            'choice_label' => 'Street + House Number',

            // choose which fields to use in the search
            // if not passed, *all* fields are used
            'searchable_fields' => ['street', 'city', 'zip', 'country'],

            'security' => 'ROLE_USER',
            'query_builder' => fn(AddressesRepository $repo) => $repo->createQueryBuilder('a')
                ->where('a.user = :user')
                ->setParameter('user', $this->security->getUser())
                ->orderBy('a.street', 'ASC'),
        ]);
    }

    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}
