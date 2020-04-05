<?php

namespace App\Security\Voter;

use App\Entity\Questions;
use http\Exception;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class QuestionVoter extends Voter
{
    const QUESTION_EDIT = 'QUESTION_EDIT';

    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['QUESTION_EDIT'])
            && $subject instanceof \App\Entity\Questions;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        /**
         * @var Questions $question
         */
        $question = $subject;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'QUESTION_EDIT':
                // logic to determine if the user can EDIT
                // return true or false
                $userRole = $user->getRoles();

                if ($question->getClient()->getId() === $user->getId())
                {
                    return true;
                }else if ( $userRole[0] === 'ROLE_ADMIN')
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
