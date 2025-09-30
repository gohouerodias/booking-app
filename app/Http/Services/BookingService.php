<?php

namespace App\Services;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class BookingService
{
    /**
     * FR: Créer une réservation avec toutes les règles métiers
     * RU: Создать бронь с проверкой всех бизнес-правил
     */
    public function createBooking(array $data): Booking
    {
        $startsAt = Carbon::parse($data['starts_at']);
        $endsAt   = Carbon::parse($data['ends_at']);

        // --- Règle 1 : pas plus de 6 heures ---
        // RU: Проверить, что длительность <= 6 часов
        if ($startsAt->diffInHours($endsAt) > 6) {
            throw ValidationException::withMessages([
                'duration' => 'FR: La durée maximale est de 6 heures / RU: Максимальная длительность — 6 часов',
            ]);
        }

        // --- Règle 2 : horaire entre 09:00 et 21:00 ---
        // RU: Проверить, что бронь находится в рабочем окне
        $startHour = $startsAt->format('H:i');
        $endHour   = $endsAt->format('H:i');

        if ($startHour < '09:00' || $endHour > '21:00') {
            throw ValidationException::withMessages([
                'time' => 'RU: Бронь должна быть между 09:00 и 21:00',
            ]);
        }

        // --- Règle 3 : pas de chevauchement ---
        // SQL logique: startA < endB && startB < endA
        $conflict = Booking::where('bed', $data['bed'])
            ->where(function ($query) use ($startsAt, $endsAt) {
                $query->where('starts_at', '<', $endsAt)
                      ->where('ends_at', '>', $startsAt);
            })
            ->exists();

        if ($conflict) {
            throw ValidationException::withMessages([
                'conflict' => 'RU: Конфликт с другой бронью',
            ])->status(409); // HTTP 409
        }

        return Booking::create($data);
    }
}
