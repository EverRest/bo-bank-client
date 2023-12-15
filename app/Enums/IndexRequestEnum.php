<?php
declare(strict_types=1);

namespace App\Enums;

use App\Enums\Enum\EnumHasToArray;

enum IndexRequestEnum: string
{
    use EnumHasToArray;
    case searchKey = 'q';
    case limitKey = 'limit';
    case pageKey = 'page';
    case sortKey = 'sort';
    case orderKey = 'order';
}
