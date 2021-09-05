<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function getVacancyLevelAttribute(): VacancyLevel
    {
        return new VacancyLevel($this->remainingCount());
    }

    /**
     * 残りの空き状況を返す
     * $this->capacity 募集人数
     * $this->reservations()->count() 予約件数
     */
    private function remainingCount(): int
    {
        return $this->capacity - $this->reservations()->count();
    }
}
