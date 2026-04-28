<?php

namespace App\Enums;

enum EngagementRole: string
{
    case STAFF = 'staff';
    case SENIOR = 'senior';
    case MANAGER = 'manager';
    case PARTNER = 'partner';
}