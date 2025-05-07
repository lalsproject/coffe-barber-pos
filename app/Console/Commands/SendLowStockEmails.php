<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendLowStockEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email notifications for low-stock products.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threshold = env('PRODUCT_STOCK_THRESHOLD', 5);
        $recipient = env('LOW_STOCK_EMAIL_RECIPIENT', 'vdsmshr@gmail.com');
        $bcc = env('LOW_STOCK_EMAIL_BCC');

        $lowStockProducts = Product::lowStock()->get();

        if ($lowStockProducts->isEmpty()) {
            $this->info('There are no low stock products.');
            return;
        }

        Mail::to($recipient)
            ->bcc($bcc ? explode(',', $bcc) : [])
            ->send(new \App\Mail\LowStockNotification($lowStockProducts, $threshold));

        $this->info('Low-stock notifications sent successfully.');
    }
}
