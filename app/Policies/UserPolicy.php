<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the given user can update the given model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function update(User $user, User $model)
    {
        return $user->id === $model->id; // Pastikan user hanya bisa mengedit dirinya sendiri
    }

    /**
     * Determine if the given user can delete the given model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function delete(User $user, User $model)
    {
        // Menolak penghapusan untuk pengguna yang mengedit dirinya sendiri
        return false; // Hanya admin atau role lain yang bisa menghapus
    }
}
