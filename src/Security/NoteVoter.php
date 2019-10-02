<?php
// src/Security/NoteVoter.php
namespace App\Security;

use App\Entity\Note;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class NoteVoter extends Voter
{
    // these strings are just invented: you can use anything
    const VIEW = 'view';
    const EDIT = 'edit';

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        // only vote on Note objects inside this voter
        if (!$subject instanceof Note) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        // ROLE_SUPER_ADMIN can do anything! The power!
        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a Note object, thanks to supports
        /** @var Note $note */
        $note = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($note, $user);
            case self::EDIT:
                return $this->canEdit($note, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Note $note, User $user)
    {
        // if they can edit, they can view
        if ($this->canEdit($note, $user)) {
            return true;
        }

        // the Note object could have, for example, a method isPrivate()
        // that checks a boolean $private property
        return !$note->isPrivate();
    }

    private function canEdit(Note $note, User $user)
    {
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        return $user === $note->getOwner();
    }
}
