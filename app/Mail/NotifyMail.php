<?php

namespace App\Mail;

use App\Action;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $blade;
    public $user;
    public $action;
    
    /**
     * Create a new message instance.
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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->blade)
                    ->with([
                        'fio' => implode(' ', [
                            $this->user->first_name,
                            $this->user->middle_name,
                            $this->user->second_name
                        ]),
                        'action' => $this->action,
                    ]);
    }
}
