<?php

namespace App\Security\Voter;

use App\Entity\Client;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileVoter extends Voter
{
    const PROFIL_EDIT = "PROFIL_EDIT";
    const QUESTION_NEW = "QUESTION_NEW";

    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['PROFIL_EDIT', 'QUESTION_NEW'])
            && $subject instanceof \App\Entity\Client;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        /**
         * @var Client $client
         */
        $client = $subject;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'PROFIL_EDIT':
                if ($client->getId() === $user->getId())
                {
                    return true;
                }else if ($client->getRoles() === "ROLE_ADMIN")
                {
                    return true;
                }else{
                    return false;
                }
                break;
            case 'QUESTION_NEW':
                // logic to determine if the user can VIEW
                // return true or false
                if ($client->getId() === $user->getId())
                {
                    return true;
                }else if ($client->getRoles() === "ROLE_ADMIN")
                {
                    return true;
                }else{
                    return false;
                }
                break;
        }

        return false;
    }
}
