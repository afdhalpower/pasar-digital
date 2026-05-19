<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\License;
use App\Notifications\OrderStatusChanged;
use App\Notifications\PaymentReceived;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('setPaid')
                ->label('Set Lunas')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->action(function () {
                    $oldPaymentStatus = $this->record->payment_status;
                    $this->record->update(['payment_status' => 'paid']);
                    $this->refreshFormData(['payment_status']);

                    if ($oldPaymentStatus !== 'paid') {
                        $this->record->user->notify(new PaymentReceived($this->record));
                    }
                }),

            Action::make('setCompleted')
                ->label('Set Selesai')
                ->icon('heroicon-o-check-badge')
                ->color('primary')
                ->requiresConfirmation()
                ->action(function () {
                    $oldStatus = $this->record->status;
                    $this->record->update([
                        'status' => 'completed',
                        'payment_status' => 'paid',
                    ]);
                    $this->refreshFormData(['status', 'payment_status']);

                    if ($oldStatus !== 'completed') {
                        $this->record->user->notify(new OrderStatusChanged(
                            $this->record, $oldStatus, 'completed'
                        ));
                    }

                    $this->generateLicenses();
                }),

            Action::make('setProcessing')
                ->label('Proses Pesanan')
                ->icon('heroicon-o-arrow-path')
                ->color('info')
                ->requiresConfirmation()
                ->action(function () {
                    $oldStatus = $this->record->status;
                    $this->record->update(['status' => 'processing']);
                    $this->refreshFormData(['status']);

                    if ($oldStatus !== 'processing') {
                        $this->record->user->notify(new OrderStatusChanged(
                            $this->record, $oldStatus, 'processing'
                        ));
                    }
                }),

            Action::make('setCancelled')
                ->label('Batalkan')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function () {
                    $oldStatus = $this->record->status;
                    $this->record->update(['status' => 'cancelled']);
                    $this->refreshFormData(['status']);

                    if ($oldStatus !== 'cancelled') {
                        $this->record->user->notify(new OrderStatusChanged(
                            $this->record, $oldStatus, 'cancelled'
                        ));
                    }
                }),

            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['total_transfer'] = $this->record->total_transfer;
        return $data;
    }

    private function generateLicenses(): void
    {
        $order = $this->record;

        foreach ($order->items as $item) {
            if ($item->product->type !== 'software') continue;

            $existing = License::where('order_item_id', $item->id)->exists();
            if ($existing) continue;

            for ($i = 0; $i < $item->quantity; $i++) {
                License::create([
                    'order_item_id' => $item->id,
                    'product_id' => $item->product_id,
                    'user_id' => $order->user_id,
                    'license_key' => License::generateKey(),
                ]);
            }
        }
    }
}
