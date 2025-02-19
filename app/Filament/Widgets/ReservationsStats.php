<?php

namespace App\Filament\Widgets;

use App\Models\Reservation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReservationsStats extends BaseWidget
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
                ->icon('heroicon-s-check-circle')
                ->description('Reservaciones aprobadas en total')
                ->color('success'),
            Stat::make('Reservaciones Pendientes', $this->getPendingReservations(new Reservation()))
                ->icon('heroicon-s-clock')
                ->description('Reservaciones pendientes en total')
                ->color('warning'),
            Stat::make('Reservaciones Rechazadas', $this->getRejectedReservations(new Reservation()))
                ->icon('heroicon-s-x-circle')
                ->description('Reservaciones rechazadas en total')
                ->color('danger'),
        ];
    }
}
