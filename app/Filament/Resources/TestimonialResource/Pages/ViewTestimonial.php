<?php

namespace App\Filament\Resources\TestimonialResource\Pages;

use App\Filament\Resources\TestimonialResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;

class ViewTestimonial extends ViewRecord
{
    protected static string $resource = TestimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('approve')
                ->label('Setujui')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn (): bool => $this->record->status !== 'approved')
                ->action(function () {
                    $this->record->update(['status' => 'approved']);
                    Notification::make()
                        ->success()
                        ->title('Testimoni Disetujui')
                        ->body('Testimoni akan ditampilkan di halaman publik.')
                        ->send();
                    $this->redirect(TestimonialResource::getUrl('index'));
                }),
            Actions\Action::make('reject')
                ->label('Tolak')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->visible(fn (): bool => $this->record->status !== 'rejected')
                ->action(function () {
                    $this->record->update(['status' => 'rejected']);
                    Notification::make()
                        ->warning()
                        ->title('Testimoni Ditolak')
                        ->body('Testimoni tidak akan ditampilkan di halaman publik.')
                        ->send();
                    $this->redirect(TestimonialResource::getUrl('index'));
                }),
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

