<?php

namespace AppBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Listener to send notification to admin when user registration detected
 */
class RegistrationCompletedListener implements EventSubscriberInterface
{
    protected $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }


    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_COMPLETED => 'onRegistrationCompletedEvent',
        );
    }


    public function onRegistrationCompletedEvent(FilterUserResponseEvent $event)
    {

        $user = $event->getUser();

            $message = \Swift_Message::newInstance()
                ->setSubject($user->getFirstname() . ' ' . $user->getLastname(). " vient de s'enregistrer")
                ->setFrom('info@radenviro.ch')
                ->setTo('info@radenviro.ch')
                ->setBody($user->getFirstname() . ' ' . $user->getLastname(). " vient de s'enregistrer.")
            ;
            $this->mailer->send($message);
    }
}

