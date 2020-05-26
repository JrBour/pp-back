<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{
    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $payload = $event->getData();
        $user = $event->getUser();

        $payload['user']['id'] = $user->getId();
        $payload['user']['firstname'] = $user->getGivenName();
        $payload['user']['lastname'] = $user->getLastName();
        $payload['user']['player_id'] = $user->getPlayerId();
        $payload['user']['email'] = $user->getEmail();
        $payload['user']['phone'] = $user->getPhone();
        $payload['user']['image'] = $user->getImage();

        $event->setData($payload);
    }
}