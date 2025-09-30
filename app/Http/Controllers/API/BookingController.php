<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function __construct(private BookingService $bookingService) {}

    /**
     * POST /api/bookings
     * RU: Создать бронь
     */
    public function store(BookingRequest $request): JsonResponse
    {
        $booking = $this->bookingService->createBooking($request->validated());
        return response()->json($booking, 201);
    }

    /**
     * GET /api/bookings?date=YYYY-MM-DD&bed=1&user_id=2
     * RU: Получить список броней с фильтрами
     */
    public function index(Request $request): JsonResponse
    {
        $query = Booking::query();

        // RU: Фильтр по дате, если указана
        if ($request->has('date')) {
            $query->whereDate('starts_at', $request->get('date'));
        }

        // RU: Фильтр по кушетке, если указана
        if ($request->has('bed')) {
            $query->where('bed', $request->get('bed'));
        }

        // RU: Фильтр по пользователю, если указан
        if ($request->has('user_id')) {
            $query->where('user_id', $request->get('user_id'));
        }

        $bookings = $query->with('user')->get();

        return response()->json($bookings);
    }

    /**
     * DELETE /api/bookings/{id}
     * RU: Удалить бронь (если принадлежит пользователю)
     */
    public function destroy($id, Request $request): JsonResponse
    {
        $booking = Booking::findOrFail($id);

        // RU: Предполагаем, что user_id передается в теле запроса для проверки
        $userId = $request->input('user_id');

        if ($booking->user_id != $userId) {
            return response()->json([
                'error' => 'FR: Vous ne pouvez supprimer que vos réservations / RU: Можно удалять только свои брони',
            ], 403);
        }

        $booking->delete();
        return response()->json(null, 204);
    }
}
