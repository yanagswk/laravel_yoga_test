<?php

namespace App\Models;

use DomainException;

class VacancyLevel
{
    private $remainingCount;

    public function __construct(int $remainingCount)
    {
        $this->remainingCount = $remainingCount;
    }

    public function mark(): string
    {
        // if ($this->remainingCount === 0) {
        //     return '×';
        // }
        // if ($this->remainingCount === 4) {
        //     return '△';
        // }
        // if ($this->remainingCount === 5) {
        //     return '◎';
        // }

        $marks = ['empty' => '×', 'few' => '△', 'enough' => '◎'];
        $slug = $this->slug();
        assert(isset($marks[$slug]), new DomainException('invalid slug value.'));

        return $marks[$slug];
    }

    public function slug(): string
    {
        if ($this->remainingCount === 0) {
            return 'empty';
        }
        if ($this->remainingCount === 4) {
            return 'few';
        }
        if ($this->remainingCount === 5) {
            return 'enough';
        }
    }

    public function __toString()
    {
        return $this->mark();
    }
}
