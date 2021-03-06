<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class KernelResponseCORSHeaders
{
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*', true);
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type', true);
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, DELETE, PATCH', true);
    }
}
