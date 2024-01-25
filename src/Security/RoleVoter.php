<?php
// src/Security/RoleVoter.php

namespace App\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class RoleVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        // Vérifie si l'attribut est égal à 'ROLE_ADMIN_OR_AGENCY'
        return $attribute === 'ROLE_ADMIN_OR_AGENCY';
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        // Obtient les rôles de l'utilisateur à partir du jeton d'authentification
        $userRoles = $token->getRoleNames();

        // Autorise l'accès si l'utilisateur a le rôle 'ROLE_ADMIN' ou 'ROLE_AGENCY'
        return in_array('ROLE_ADMIN', $userRoles) || in_array('ROLE_AGENCY', $userRoles);
    }
}
