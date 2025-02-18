<?php

namespace App\Filament\Dashboard\Resources\ReservationResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Dashboard\Resources\ReservationResource;

class CreateReservation extends CreateRecord
{
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        $data['status'] = 'pendiente';

        return $data;
    }

    protected static string $resource = ReservationResource::class;
}
