<?php

namespace Tests;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;

trait ApiAuthorization{

    /**
     * Set the currently logged in user for the application.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string|null  $driver
     * @return $this
     */
    public function actingAs(UserContract $user, $driver = null)
    {
        $this->authUser = $user;
        return parent::actingAs($user, $driver);
    }

    /**
     * Call the given URI with a JSON request.
     *
     * @param  string  $method
     * @param  string  $uri
     * @param  array  $data
     * @param  array  $headers
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function json($method, $uri, array $data = [], array $headers = [])
    {
        $headers['Authorization'] = "Bearer {$this->authUser->api_token}";
        return parent::json($method, $uri, $data, $headers);
    }

}