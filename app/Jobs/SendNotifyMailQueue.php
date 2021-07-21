<?php

namespace App\Jobs;

use App\Action;
use App\Mail\NotifyMail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Facades\Mail;

class SendNotifyMailQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $blade;
    public $user;
    public $action;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($blade, User $user, Action $action = null)
    {
        $this->blade = $blade;
        $this->user = $user;
        $this->action = $action;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $to = $this->user->email;
        $mail = new NotifyMail($this->blade, $this->user, $this->action);

		Mail::to($to)
            ->send($mail);
    }
}
