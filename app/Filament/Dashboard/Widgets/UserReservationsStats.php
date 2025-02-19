<?php

namespace App\Filament\Dashboard\Widgets;

use App\Models\Reservation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserReservationsStats extends BaseWidget
{
    protected function getApprovedReservations(Reservation $reservation)
    {
        return $reservation->where('status', 'aprobada')->count();
    }

    protected function getPendingReservations(Reservation $reservation)
    {
        return $reservation->where('status', 'pendiente')->count();
    }

    protected function getRejectedReservations(Reservation $reservation)
    {
        return $reservation->where('status', 'rechazada')->count();
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Reservaciones Aprobadas', $this->getApprovedReservations(new Reservation()))
                ->color('success')
                ->icon('heroicon-s-check-circle')
                ->description('Reservaciones aprobadas en total'),
            Stat::make('Reservaciones Pendientes', $this->getPendingReservations(new Reservation()))
                ->color('warning')
                ->icon('heroicon-s-clock')
                ->description('Reservaciones pendientes en total'),
            Stat::make('Reservaciones Rechazadas', $this->getRejectedReservations(new Reservation()))
                ->color('danger')
                ->icon('heroicon-s-x-circle')
                ->description('Reservaciones rechazadas en total'),
        ];
    }
}
