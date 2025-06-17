<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendInvoiceDueReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:send-due-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for invoices due soon or today';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Sending invoice due reminders...');
        
        $today = now()->format('Y-m-d');
        $threeDaysFromNow = now()->addDays(3)->format('Y-m-d');
        
        // Invoices due today
        $dueTodayCount = $this->sendRemindersForDate($today, 0);
        $this->info("Sent {$dueTodayCount} reminders for invoices due today.");
        
        // Invoices due in 3 days
        $dueIn3DaysCount = $this->sendRemindersForDate($threeDaysFromNow, 3);
        $this->info("Sent {$dueIn3DaysCount} reminders for invoices due in 3 days.");
        
        $this->info('Finished sending invoice due reminders.');
        
        return Command::SUCCESS;
    }
    
    /**
     * Send reminders for invoices due on a specific date
     */
    private function sendRemindersForDate(string $dueDate, int $daysUntilDue): int
    {
        $count = 0;
        
        $invoices = Invoice::where('status', 'pendente')
            ->whereDate('due_date', $dueDate)
            ->with('user')
            ->get();
        
        foreach ($invoices as $invoice) {
            try {
                if ($invoice->user) {
                    $invoice->sendDueReminder($daysUntilDue);
                    $count++;
                    
                    $this->line("Sent reminder for invoice #{$invoice->invoice_number}");
                }
            } catch (\Exception $e) {
                Log::error('Failed to send invoice due reminder', [
                    'invoice_id' => $invoice->id,
                    'error' => $e->getMessage()
                ]);
                
                $this->error("Failed to send reminder for invoice #{$invoice->invoice_number}: {$e->getMessage()}");
            }
        }
        
        return $count;
    }
}
