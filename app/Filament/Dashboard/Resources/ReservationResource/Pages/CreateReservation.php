<?php

namespace App\Filament\Dashboard\Resources\ReservationResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Dashboard\Resources\ReservationResource;
use App\Mail\ReservationPending;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class CreateReservation extends CreateRecord
{
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();
        $data['user_id'] = $user->id;
        $data['status'] = 'pendiente';

        $reservation = Reservation::create($data);
        $userAdmin = User::where('id', 1)->first();

        Mail::to($userAdmin)->send(new ReservationPending($reservation));

        return $data;
    }

    protected static string $resource = ReservationResource::class;
}
