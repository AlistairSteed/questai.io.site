<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $first_name;
    public $last_name;
    public $user_email;
    public $user_password;
    public $enterpriseId;

    public function __construct($first_name, $last_name, $user_email, $user_password, $enterpriseId)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->user_email = $user_email;
        $this->user_password = $user_password;
        $this->enterpriseId = $enterpriseId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.user_register')
            ->subject('User Registered')
            ->replyTo($this->user_email, $this->first_name.' '.$this->last_name)
            ->with([
                'user_name' => $this->first_name.' '.$this->last_name,
                'email_id' => $this->user_email,
                'password' => $this->user_password,
                'enterpriseId' => $this->enterpriseId,
                'link' => $this->enterpriseId,
            ]);
    }
}
