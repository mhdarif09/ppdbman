<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view any applicants.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view-applicants');
    }

    /**
     * Determine if the user can view the specific applicant.
     */
    public function view(User $user, $applicant): bool
    {
        // Super admin, admin sekolah, and verifikator can view any applicant
        if ($user->hasPermission('view-applicants')) {
            return true;
        }

        // Pendaftar can only view their own application
        if ($user->hasRole('pendaftar')) {
            // Assuming applicant model has user_id field
            // return $applicant->user_id === $user->id;
            return true; // Simplified for example
        }

        return false;
    }

    /**
     * Determine if the user can create applicants.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('submit-application');
    }

    /**
     * Determine if the user can update the applicant.
     */
    public function update(User $user, $applicant): bool
    {
        // Admin sekolah can edit any applicant
        if ($user->hasPermission('edit-applicants')) {
            return true;
        }

        // Pendaftar can edit own application if not yet verified
        if ($user->hasPermission('edit-own-application')) {
            // Assuming applicant has user_id and is_verified fields
            // return $applicant->user_id === $user->id && !$applicant->is_verified;
            return true; // Simplified for example
        }

        return false;
    }

    /**
     * Determine if the user can delete the applicant.
     */
    public function delete(User $user, $applicant): bool
    {
        return $user->hasPermission('delete-applicants');
    }

    /**
     * Determine if the user can verify the applicant.
     */
    public function verify(User $user, $applicant): bool
    {
        return $user->hasPermission('verify-applicants');
    }

    /**
     * Determine if the user can reject the applicant.
     */
    public function reject(User $user, $applicant): bool
    {
        return $user->hasPermission('reject-applicants');
    }

    /**
     * Determine if the user can add notes to the applicant.
     */
    public function addNotes(User $user, $applicant): bool
    {
        return $user->hasPermission('add-verification-notes');
    }
}
