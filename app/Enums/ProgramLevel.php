<?php

namespace App\Enums;

enum ProgramLevel: string
{
    case Bachelor = 'bachelor';
    case Master = 'master';
    case Phd = 'phd';

    public function label(): string
    {
        return match ($this) {
            self::Bachelor => 'بكالوريوس',
            self::Master => 'ماجستير',
            self::Phd => 'دكتوراه',
        };
    }
}
