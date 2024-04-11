<?php

namespace App\Custom;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Session\DatabaseSessionHandler;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CustomDataBaseSessionHandler extends DatabaseSessionHandler
{
    protected function addUserInformation(&$payload)
    {
        if ($this->container->bound(Guard::class)) {
            $payload['user_id'] = $this->userId();
            $payload['sites'] = $this->container->make('request')->input('sites');
        }
        return $this;
    }
    /**
     * Perform an insert operation on the session ID.
     *
     * @param  string  $sessionId
     * @param  array<string, mixed>  $payload
     * @return bool|null
     */
    protected function performInsert($sessionId, $payload)
    {

        try {
            $payload['id'] = $sessionId; // Set the session ID in the payload
            return $this->getQuery()->where('user_id', $this->userId())->where('sites', $this->container->make('request')->input('sites'))->insert($payload);
        } catch (QueryException) {
            // If an exception occurs, perform an update
            $this->performUpdate($sessionId, $payload);
        }
    }
}
