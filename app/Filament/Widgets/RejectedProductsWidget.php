<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class RejectedProductsWidget extends BaseWidget
{
    protected static ?string $heading = 'Produk yang Ditolak';
    
    protected static ?int $sort = 5;
    
    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        // Hanya superadmin dan admin yang bisa melihat widget ini
        $user = Auth::user();
        return $user && ($user->level_id === 1 || $user->level_id === 2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->where('status', 'rejected')
                    ->with(['businessCategory', 'user', 'verifier'])
                    ->orderBy('verified_at', 'desc')
            )
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->square()
                    ->size(40),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Produk')
                    ->limit(25)
                    ->searchable()
                    ->tooltip(fn (Product $record): string => $record->name),
                Tables\Columns\TextColumn::make('owner_name')
                    ->label('Pemilik')
                    ->limit(20)
                    ->searchable(),
                Tables\Columns\TextColumn::make('rejection_reason')
                    ->label('Alasan Penolakan')
                    ->limit(40)
                    ->wrap()
                    ->tooltip(fn (Product $record): ?string => $record->rejection_reason)
                    ->icon('heroicon-o-exclamation-circle')
                    ->iconColor('danger')
                    ->color('danger')
                    ->weight('medium'),
                Tables\Columns\TextColumn::make('verifier.name')
                    ->label('Ditolak Oleh')
                    ->default('-')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('verified_at')
                    ->label('Tanggal Ditolak')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view_reason')
                    ->label('Lihat Detail')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading('Detail Alasan Penolakan')
                    ->modalContent(fn (Product $record) => view('filament.widgets.rejection-detail', [
                        'product' => $record
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),
                    
                Tables\Actions\Action::make('approve_now')
                    ->label('Setujui Sekarang')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function (Product $record) {
                        $record->update([
                            'status' => 'approved',
                            'rejection_reason' => null, // Clear rejection reason
                            'verified_at' => now(),
                            'verified_by' => auth()->id(),
                        ]);
                        
                        Notification::make()
                            ->success()
                            ->title('Produk Disetujui')
                            ->body('Produk "' . $record->name . '" telah disetujui.')
                            ->send();
                            
                        $this->resetTable();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Setujui Produk')
                    ->modalDescription('Produk yang sebelumnya ditolak akan disetujui. Alasan penolakan akan dihapus.')
                    ->modalSubmitActionLabel('Ya, Setujui'),
                    
                Tables\Actions\Action::make('edit_reason')
                    ->label('Edit Alasan')
                    ->icon('heroicon-o-pencil')
                    ->color('warning')
                    ->form([
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Alasan Penolakan Baru')
                            ->required()
                            ->maxLength(500)
                            ->rows(4)
                            ->default(fn (Product $record) => $record->rejection_reason)
                    ])
                    ->action(function (Product $record, array $data) {
                        $record->update([
                            'rejection_reason' => $data['rejection_reason'],
                            'verified_at' => now(),
                            'verified_by' => auth()->id(),
                        ]);
                        
                        Notification::make()
                            ->success()
                            ->title('Alasan Diperbarui')
                            ->body('Alasan penolakan telah diperbarui.')
                            ->send();
                            
                        $this->resetTable();
                    })
                    ->modalHeading('Edit Alasan Penolakan')
                    ->modalSubmitActionLabel('Simpan'),
            ])
            ->defaultSort('verified_at', 'desc')
            ->paginated([5, 10, 25])
            ->poll('30s'); // Auto refresh setiap 30 detik
    }
}
