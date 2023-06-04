<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;
use App\Models\Expense;

class ExpenseNotify extends Notification implements ShouldQueue
{
    use Queueable;

    private $expense;

    public function __construct(Expense $expense)
    {
        $this->expense = $expense;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Onfly | Despesa cadastrada')
            ->greeting('Olá, ' . $notifiable->name)
            ->line('Você tem uma nova despesa registrada!')
            ->line('Descrição da despesa : ' . $this->expense->description)
            ->line('Valor: R$ ' . number_format($this->expense->amount, 2, ',', '.'))
            ->line('Data: ' . date('d/m/Y', strtotime($this->expense->date)))
            ->salutation("Atenciosamente, Onfly.");
    }
}
