<?php

namespace App\Security\Voter;

use App\Entity\Comments;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class CommentVoter extends Voter
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
        return in_array($attribute, ['COMMENT_EDIT', 'COMMENT_DELETE'])
            && $subject instanceof Comments;
    }

    protected function voteOnAttribute(string $attribute, $comment, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'COMMENT_EDIT':
                //the modification of the comment is authorized only if the connected user
                // is the author of the comment or if he has the ADMIN

                if ($comment->getUser() === $user) {
                    return true;

                }

                if ($this->security->isGranted('ROLE_ADMIN')) {
                    return true;
                }
                break;
            case 'COMMENT_DELETE':
                //the removal of the comment is authorized only if the connected user
                // is the author of the comment or if he has the ADMIN

                if ($comment->getUser() === $user) {
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
