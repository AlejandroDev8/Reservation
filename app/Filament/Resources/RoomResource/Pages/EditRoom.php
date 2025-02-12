<?php

namespace App\Filament\Resources\RoomResource\Pages;

use Filament\Actions;
use App\Filament\Resources\RoomResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditRoom extends EditRecord
{
    protected static string $resource = RoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('¡Sala Actualizada!')
            ->body('La sala ha sido actualizada exitosamente.');
    }
}
