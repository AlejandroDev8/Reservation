<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Reservation;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ReservationResource\Pages;
use App\Filament\Resources\ReservationResource\RelationManagers;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-s-calendar';

    protected static ?string $modelLabel = 'Reservaciones';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->orderBy('id', 'desc');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship(name: 'user', titleAttribute: 'name')
                    ->label('Usuario')
                    ->required(),
                Forms\Components\Select::make('room_id')
                    ->relationship(name: 'room', titleAttribute: 'name')
                    ->label('Sala')
                    ->required(),
                Forms\Components\Select::make('distribution_id')
                    ->relationship(name: 'distribution', titleAttribute: 'name')
                    ->label('Distribución de Sillas')
                    ->required(),
                Forms\Components\DatePicker::make('start_date')
                    ->label('Fecha de Inicio')
                    ->native(false)
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->label('Fecha de Fin')
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Estado de la Reserva')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'aprobada' => 'Aprobada',
                        'rechazada' => 'Rechazada',
                    ])
                    ->required()
                    ->default('pendiente'),
                Forms\Components\Textarea::make('notes')
                    ->label('Notas Extras')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('answer')
                    ->label('Respuesta')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('room.name')
                    ->label('Sala')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('distribution.name')
                    ->label('Distribución de Sillas')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Fecha de Inicio')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Fecha de Fin')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado de la Reserva')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'aprobada' => 'success',
                        'rechazada' => 'danger',
                        'pendiente' => 'warning',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Estado de la Reserva')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'aprobada' => 'Aprobada',
                        'rechazada' => 'Rechazada',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->exports([
                            ExcelExport::make('table')->fromTable()
                                ->withFilename('Reservaciones_' . date('d-m-Y') . '_export')
                                ->label('Exportar en formato Tabla')
                                ->askForFilename()
                                ->askForWriterType(),
                            ExcelExport::make('form')->fromForm()
                                ->withFilename('Reservaciones_' . date('d-m-Y') . '_export')
                                ->label('Exportar en formato Formulario')
                                ->askForFilename()
                                ->askForWriterType(),
                        ])
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }
}
