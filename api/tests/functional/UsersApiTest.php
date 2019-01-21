<?php

namespace App\Tests;

use App\Tests\functional\EmptyDatabaseTestCase;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

class UsersApiTest extends EmptyDatabaseTestCase
{
    /** @var Client */
    private $client;

    protected function setUp()
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    public function testUserCreate(): void
    {
        $this->request(
            'POST',
            '/api/users',
            '{
           "name":"Leanne Graham",
           "username":"Bret",
           "email":"Sincere@april.biz",
           "address":{
              "street":"Kulas Light",
              "suite":"Apt. 556",
              "city":"Gwenborough",
              "zipcode":"92998-3874",
              "geo":{
                 "lat":"-37.3159",
                 "lng":"81.1496"
              }
           },
           "phone":"1-770-736-8031 x56442",
           "website":"hildegard.org",
           "company":{
              "name":"Romaguera-Crona",
              "catchPhrase":"Multi-layered client-server neural-net",
              "bs":"harness real-time e-markets"
           }
        }'
        );

        static::assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $this->responseEqualsJson(
            '{
        "id":1,
        "name":"Leanne Graham",
        "username":"Bret",
        "email":"Sincere@april.biz",
        "address":{
            "street":"Kulas Light",
            "suite":"Apt. 556",
            "city":"Gwenborough",
            "zipcode":"92998-3874",
            "geo":{"lat":"-37.31590000","lng":"81.14960000"}
        },
        "phone":"1-770-736-8031 x56442",
        "website":"hildegard.org",
        "company":{
            "name":"Romaguera-Crona",
            "catchPhrase":"Multi-layered client-server neural-net",
            "bs":"harness real-time e-markets"}
        }'
        );
    }

    public function testUserRead(): void
    {
        $this->request('GET', '/api/users/1');

        static::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->responseEqualsJson(
            '{
        "id":1,
        "name":"Leanne Graham",
        "username":"Bret",
        "email":"Sincere@april.biz",
        "address":{
            "street":"Kulas Light",
            "suite":"Apt. 556",
            "city":"Gwenborough",
            "zipcode":"92998-3874",
            "geo":{"lat":"-37.31590000","lng":"81.14960000"}
        },
        "phone":"1-770-736-8031 x56442",
        "website":"hildegard.org",
        "company":{
            "name":"Romaguera-Crona",
            "catchPhrase":"Multi-layered client-server neural-net",
            "bs":"harness real-time e-markets"}
        }'
        );
    }

    public function testUserReadList(): void
    {
        $this->request('GET', '/api/users');

        static::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->responseEqualsJson(
            '{
           "users":[
              {
                 "id":1,
                 "name":"Leanne Graham",
                 "username":"Bret",
                 "email":"Sincere@april.biz",
                 "address":{
                    "street":"Kulas Light",
                    "suite":"Apt. 556",
                    "city":"Gwenborough",
                    "zipcode":"92998-3874",
                    "geo":{
                       "lat":"-37.31590000",
                       "lng":"81.14960000"
                    }
                 },
                 "phone":"1-770-736-8031 x56442",
                 "website":"hildegard.org",
                 "company":{
                    "name":"Romaguera-Crona",
                    "catchPhrase":"Multi-layered client-server neural-net",
                    "bs":"harness real-time e-markets"
                 }
              }
           ],
           "currentPage": 1,
           "prevUri":null,
           "nextUri":null
        }'
        );
    }

    public function testUserUpdate(): void
    {
        $this->request(
            'PATCH',
            '/api/users/1',
            '{
            "username": "Antonette",
            "email": "Shanna@melissa.tv",
            "address": {
              "street": "Victor Plains",
              "city": "Wisokyburgh",
              "zipcode": "90566-7771",
              "geo": {
                "lat": "-43.9509",
                "lng": "-34.4618"
              }
            },
            "company": {
              "bs": "synergize scalable supply-chains"
            }
        }'
        );

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->responseEqualsJson(
            '{
            "id":1,
            "name":"Leanne Graham",
            "username":"Antonette",
            "email":"Shanna@melissa.tv",
            "address":{
                "street":"Victor Plains",
                "suite":"Apt. 556",
                "city":"Wisokyburgh",
                "zipcode":"90566-7771",
                "geo":{"lat":"-43.95090000","lng":"-34.46180000"}
            },
            "phone":"1-770-736-8031 x56442",
            "website":"hildegard.org",
            "company":{
                "name":"Romaguera-Crona",
                "catchPhrase":"Multi-layered client-server neural-net",
                "bs":"synergize scalable supply-chains"
            }
        }'
        );
    }

    public function testUserDelete(): void
    {
        $this->request('DELETE', '/api/users/1');

        $this->assertEquals(Response::HTTP_NO_CONTENT, $this->client->getResponse()->getStatusCode());
    }

    private function request(string $method, string $uri, ?string $json = null): Crawler
    {
        $params = $json ? \json_decode($json, true) : [];

        return $this->client->request($method, $uri, $params, [], [], $json);
    }

    private function responseArray(): array
    {
        return \json_decode($this->client->getResponse()->getContent(), true);
    }

    private function responseEqualsJson($json): void
    {
        $response = $this->responseArray();

        static::assertEquals(\json_decode($json, true), $response);
    }
}
