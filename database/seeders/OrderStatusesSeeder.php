<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        OrderStatus::truncate();

        // And now, let's create a few groups in our database:
        OrderStatus::create([
            'order_status_id' => 0,
            'name' => "On Hold"
        ]);
        OrderStatus::create([
            'order_status_id' => 1,
            'name' => "Preparing"
        ]);
        OrderStatus::create([
            'order_status_id' => 2,
            'name' => "In Cargo"
        ]);
        OrderStatus::create([
            'order_status_id' => 3,
            'name' => "Completed"
        ]);
        OrderStatus::create([
            'order_status_id' => 4,
            'name' => "Cancelled"
        ]);
    }
}
