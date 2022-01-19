<?php

namespace App\Policies;

use App\Gebruiker;
use App\Gebruikersprofiel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class GebruikersprofielPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
{
    return $user->hasRole("Administrator")
        ? Response::allow()
        : Response::deny("Je moet administrator zijn voor deze actie.");
}

    /**
     * Determine whether the user can view any gebruikersprofiels.
     *
     * @param  \App\Gebruiker  $user
     * @return mixed
     */
    public function viewAny(Gebruiker $user)
    {
    }

    /**
     * Determine whether the user can view the gebruikersprofiel.
     *
     * @param  \App\Gebruiker  $user
     * @param  \App\Gebruikersprofiel  $gebruikersprofiel
     * @return mixed
     */
    public function view(Gebruiker $user, Gebruikersprofiel $gebruikersprofiel)
    {
        error_log($user);
        return $user->hasRole("Administrator");
    }

    /**
     * Determine whether the user can create gebruikersprofiels.
     *
     * @param  \App\Gebruiker  $user
     * @return mixed
     */
    public function create(Gebruiker $user)
    {
        //
    }

    /**
     * Determine whether the user can update the gebruikersprofiel.
     *
     * @param  \App\Gebruiker  $user
     * @param  \App\Gebruikersprofiel  $gebruikersprofiel
     * @return mixed
     */
    public function update(Gebruiker $user, Gebruikersprofiel $gebruikersprofiel)
    {
        //
    }

    /**
     * Determine whether the user can delete the gebruikersprofiel.
     *
     * @param  \App\Gebruiker  $user
     * @param  \App\Gebruikersprofiel  $gebruikersprofiel
     * @return mixed
     */
    public function delete(Gebruiker $user, Gebruikersprofiel $gebruikersprofiel)
    {
        //
    }

    /**
     * Determine whether the user can restore the gebruikersprofiel.
     *
     * @param  \App\Gebruiker  $user
     * @param  \App\Gebruikersprofiel  $gebruikersprofiel
     * @return mixed
     */
    public function restore(Gebruiker $user, Gebruikersprofiel $gebruikersprofiel)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the gebruikersprofiel.
     *
     * @param  \App\Gebruiker  $user
     * @param  \App\Gebruikersprofiel  $gebruikersprofiel
     * @return mixed
     */
    public function forceDelete(Gebruiker $user, Gebruikersprofiel $gebruikersprofiel)
    {
        //
    }
}
