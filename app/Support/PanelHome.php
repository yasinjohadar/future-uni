<?php

namespace App\Support;

use App\Models\User;

class PanelHome
{
    public static function routeName(?User $user): string
    {
        if (! $user) {
            return 'home';
        }

        if ($user->hasAnyRole([
            'admin',
            'super-admin',
            'content-editor',
            'admissions-officer',
            'registrar',
        ])) {
            return 'admin.dashboard';
        }

        if ($user->hasRole('doctor')) {
            return 'doctor.dashboard';
        }

        if ($user->hasRole('student')) {
            return 'student.dashboard';
        }

        return 'home';
    }

    public static function url(?User $user): string
    {
        $name = static::routeName($user);

        return route($name);
    }
}
