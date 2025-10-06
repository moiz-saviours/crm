<?php

namespace App\Policies\Client;

use App\Models\ClientContact;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class ContactPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user): bool
    {
        return $user->hasPermission(ClientContact::class, 'view_any');
    }

    public function view(User $user, ClientContact $contact): bool
    {
        return $user->hasPermission($contact, 'view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission(ClientContact::class, 'create');
    }

    public function update(User $user, ClientContact $contact): bool
    {
        return $user->hasPermission($contact, 'update');
    }

    public function delete(User $user, ClientContact $contact): bool
    {
        return $user->hasPermission($contact, 'delete');
    }

    public function changeStatus(User $user, ClientContact $contact): bool
    {
        return $user->hasPermission($contact, 'change_status');
    }
}
