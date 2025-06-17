<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckOverdueInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:check-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for overdue invoices and update their status';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Checking for overdue invoices...');
        
        $today = now()->format('Y-m-d');
        
        // Find pending invoices with due dates in the past
        $overdueInvoices = Invoice::where('status', 'pendente')
            ->whereDate('due_date', '<', $today)
            ->get();
        
        $count = 0;
        
        foreach ($overdueInvoices as $invoice) {
            try {
                $invoice->update(['status' => 'vencida']);
                $count++;
                
                $this->line("Updated invoice #{$invoice->invoice_number} to overdue status");
            } catch (\Exception $e) {
                Log::error('Failed to update overdue invoice status', [
                    'invoice_id' => $invoice->id,
                    'error' => $e->getMessage()
                ]);
                
                $this->error("Failed to update invoice #{$invoice->invoice_number}: {$e->getMessage()}");
            }
        }
        
        $this->info("Updated {$count} invoices to overdue status.");
        
        return Command::SUCCESS;
    }
}
