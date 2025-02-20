<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ReservationResource;
use App\Mail\ReservationApproved;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EditReservation extends EditRecord
{
    protected static string $resource = ReservationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('¡Reservación actualizado!')
            ->body('La reservación ha sido actualizado correctamente.');
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $oldStatus = $record->getOriginal('status'); // Obtener estado antes de actualizar

        $record->update($data); // Actualizar la reserva con los nuevos datos

        // Enviar correo solo si el estado cambió a "aprobada"
        if ($oldStatus !== 'aprobada' && $record->status === 'aprobada') {
            $user = User::find($record->user_id);
            if ($user) {
                Mail::to($user)->send(new ReservationApproved($record));
            }
        }

        return $record;
    }
}
