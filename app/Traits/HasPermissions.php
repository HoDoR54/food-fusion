<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasPermissions
{
    private function authorize(string $action, string $resource): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        return $user->hasPermission($action, $resource);
    }

    public function authorizeOrFail(string $action, string $resource): void
    {
        if (! $this->authorize($action, $resource)) {
            abort(403, 'You do not have permission to perform this action.');
        }
    }
}
