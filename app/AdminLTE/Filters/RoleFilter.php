<?php

namespace App\AdminLTE\Filters;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function transform($item)
    {
        // Vérifie si l'item du menu a un rôle défini
        if (isset($item['role']) && !auth()->user()->hasRole($item['role'])) {
            return false; // masque l'item
        }

        return $item; // garde l'item
    }
}
