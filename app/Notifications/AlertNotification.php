<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AlertNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $data;
    protected $difference;

    public function __construct($data,$difference)
    {
        $this->data = $data;
        $this->difference = $difference;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->subject('Alert Notification To  '.$this->data->getUser->name)
        ->greeting("Hello ".$this->data->getUser->name)
        ->line('This notification to alert you '.$this->data->getUser->name.' that You have serviced your car on ' .$this->data->date_time.'....')
        ->line('Here The Car details for which You have booked services')
        ->line('Car Brand - '.$this->data->carTrim->carmodel->years->cars->brand)
        ->line('Car Year - '.$this->data->carTrim->carmodel->years->year)
        ->line('Car Modal - '.$this->data->carTrim->carmodel->modal_name)
        ->line('Car Trim - '.$this->data->carTrim->car_trim_name)
        ->line('So Your next car Service due date is '. $this->difference .' !')
        ->line('So Do your car Service as if you need...Thank You!')
        ->action('Go to Uncle Fitter', url('/'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
