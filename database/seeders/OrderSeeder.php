<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        if (Order::exists()) {
            $this->command->info('Orders already exist, skipping.');
            return;
        }

        $customer = User::where('role', 'customer')->first() ?? User::first();
        $menus = Menu::where('is_available', true)->get();

        if (! $customer || $menus->count() < 3) {
            $this->command->warn('Need at least one user and 3 available menus.');
            return;
        }

        $samples = [
            [Order::STATUS_PENDING, 3, 'No chili please'],
            [Order::STATUS_PENDING, 7, null],
            [Order::STATUS_PROCESSING, 5, 'Less sugar'],
            [Order::STATUS_READY, 2, null],
            [Order::STATUS_COMPLETED, 4, null],
            [Order::STATUS_COMPLETED, 6, 'Extra napkins'],
            [Order::STATUS_CANCELLED, 1, null],
        ];

        foreach ($samples as $i => [$status, $table, $note]) {
            $placedAt = now()->subMinutes((count($samples) - $i) * 25);

            $order = Order::create([
                'user_id' => $customer->id,
                'total_price' => 0,
                'status' => $status,
                'table_number' => $table,
                'note' => $note,
                'completed_at' => $status === Order::STATUS_COMPLETED ? $placedAt->copy()->addMinutes(20) : null,
            ]);

            $total = 0;

            foreach ($menus->random(rand(1, 3)) as $menu) {
                $qty = rand(1, 3);

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $menu->id,
                    'quantity' => $qty,
                    'price' => $menu->price,
                ]);

                $total += $qty * $menu->price;
            }

            $order->forceFill([
                'total_price' => $total,
                'created_at' => $placedAt,
                'updated_at' => $placedAt,
            ])->save();
        }
    }
}
