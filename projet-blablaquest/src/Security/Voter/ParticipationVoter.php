<?php

namespace App\Security\Voter;

use App\Entity\Participation;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ParticipationVoter extends Voter
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['PARTICIPATION_DELETE', 'PARTICIPATION_VALIDATE', 'PARTICIPATION_REFUSE'])
            && $subject instanceof Participation;
    }

    protected function voteOnAttribute(string $attribute, $participation, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'PARTICIPATION_DELETE':
                //the removal of the event is authorized only if the connected user
                // is the author of the event or if he has the ADMIN
                if ($participation->getUser() === $user) {
                    return true;
                }
                
                if ($user === $participation->getEvent()->getUser()) {
                    return true;

                }


                if ($this->security->isGranted('ROLE_ADMIN')) {
                    return true;
                }
                break;
            case 'PARTICIPATION_VALIDATE':
                //We authorize the validation of the participation only if we are the organizer of the event or the ADMIN
                if ($user === $participation->getEvent()->getUser()) {
                    return true;

                }

                if ($this->security->isGranted('ROLE_ADMIN')) {
                    return true;
                }
                break;
            case 'PARTICIPATION_REFUSE':
                //We authorize the refusal of the participation only if we are the organizer of the event or the ADMIN
                if ($user === $participation->getEvent()->getUser()) {
                    return true;

                }

                if ($this->security->isGranted('ROLE_ADMIN')) {
                    return true;
                }
                break;
        }

        return false;
    }
}
