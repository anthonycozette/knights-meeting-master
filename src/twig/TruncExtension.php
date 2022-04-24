<?php

namespace App\twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TruncExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('personal_trunc', [$this, 'truncate'])
        ];
    }

    public function truncate($value)
    {
        return substr($value, 0, 500) . '...';
    }
}
