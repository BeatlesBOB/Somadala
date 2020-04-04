<?php

namespace App\Security\Voter;

use App\Entity\Client;
use App\Entity\Panier;
use App\Entity\Questions;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\VarDumper\VarDumper;


class ClientVoter extends Voter
{
    const PANIER_EDIT = 'PANIER_EDIT';
    const PANIER_SHOW = 'PANIER_EDIT';
    const CLIENT_EDIT = 'CLIENT_EDIT';
    const QUESTION_EDIT = 'QUESTION_EDIT';


    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['PANIER_EDIT', 'PANIER_SHOW','CLIENT_EDIT','QUESTION_EDIT'])
            && $subject instanceof \App\Entity\Panier;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        /**
         * @var Panier $panier
         */
        $panier = $subject;


        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'PANIER_EDIT':
                // logic to determine if the user can EDIT
                // return true or false
                return $panier->getClientId()->getId() === $user->getId();
                break;
            case 'PANIER_SHOW':
                // logic to determine if the user can VIEW
                // return true or false
                return $panier->getClientId()->getId() === $user->getId();
                break;
        }

        return false;
    }
}
