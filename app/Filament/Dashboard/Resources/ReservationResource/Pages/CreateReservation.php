<?php

namespace App\Filament\Dashboard\Resources\ReservationResource\Pages;

use App\Models\User;
use Filament\Actions;
use App\Models\Reservation;
use App\Mail\ReservationPending;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Dashboard\Resources\ReservationResource;

class CreateReservation extends CreateRecord
{
    protected static string $resource = ReservationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();
        $data['user_id'] = $user->id;
        $data['status'] = 'pendiente';

        return $data; // No crear manualmente la reservación aquí
    }

    protected function afterCreate(): void
    {
        $reservation = $this->record; // Filament ya ha creado la reservación
        $userAdmin = User::where('id', 1)->first();

        Mail::to($userAdmin)->send(new ReservationPending($reservation));
    }


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Reservación Creada')
            ->body('La reservación ha sido creada exitosamente.');
    }
}
