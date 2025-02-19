<?php

namespace App\Filament\Dashboard\Widgets;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class UserReservationsStats extends BaseWidget
{
    protected function getApprovedReservations(User $user)
    {
        $totalApprovedReservations = Reservation::where('user_id', $user->id)
            ->where('status', 'aprobada')->get()->count();

        return $totalApprovedReservations;
    }

    protected function getPendingReservations(User $user)
    {
        $totalPendingReservations = Reservation::where('user_id', $user->id)
            ->where('status', 'pendiente')->get()->count();

        return $totalPendingReservations;
    }

    protected function getRejectedReservations(User $user)
    {
        $totalRejectedReservations = Reservation::where('user_id', $user->id)
            ->where('status', 'rechazada')->get()->count();

        return $totalRejectedReservations;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Reservaciones Aprobadas', $this->getApprovedReservations(Auth::user()))
                ->color('success')
                ->icon('heroicon-s-check-circle')
                ->description('Reservaciones aprobadas en total'),
            Stat::make('Reservaciones Pendientes', $this->getPendingReservations(Auth::user()))
                ->color('warning')
                ->icon('heroicon-s-clock')
                ->description('Reservaciones pendientes en total'),
            Stat::make('Reservaciones Rechazadas', $this->getRejectedReservations(Auth::user()))
                ->color('danger')
                ->icon('heroicon-s-x-circle')
                ->description('Reservaciones rechazadas en total'),
        ];
    }
}
