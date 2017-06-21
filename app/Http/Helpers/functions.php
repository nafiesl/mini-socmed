<?php

function getNotificationViewPart($notifClass)
{
    $notifClass = str_replace('App\Notifications\\', '', $notifClass);
    $notifClass = str_replace('\\', '.', $notifClass);
    $notifClass = str_slug(snake_case($notifClass));
    return $notifClass;
}