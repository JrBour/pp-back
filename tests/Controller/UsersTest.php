<?php
namespace App\Tests\Controller;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class UsersTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testGetCollection(): void
    {
        static::createClient()->request('GET', '/users');
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertMatchesResourceCollectionJsonSchema(User::class);
    }

    public function testCreateUser(): void
    {
        $response = static::createClient()->request('POST', '/register', ['json' => [
            'givenName' => 'Margaret',
            'lastName' => 'Tutcher',
            'phone' => '0123456789',
            'email' => 'jo@Jo.com',
            'password' => 'passwordz12',
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJsonContains([
            'givenName' => 'Margaret',
            'lastName' => 'Tutcher',
            'phone' => '0123456789',
            'email' => 'jo@Jo.com',
            'password' => 'passwordz12',
        ]);

        $this->assertRegExp('~^/users/\d+$~', $response->toArray()['id']);
        $this->assertMatchesResourceItemJsonSchema(User::class);
    }

    public function testUpdateUser(): void
    {
        $response = static::createClient()->request('PATCH', '/users/1', ['json' => [
            'givenName' => 'Margaret',
            'lastName' => 'Tutcher',
            'phone' => '0123456789',
            'email' => 'jo@Jo.com',
            'password' => 'passwordz12',
        ]]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJsonContains([
            'givenName' => 'Margaret',
            'lastName' => 'Tutcher',
            'phone' => '0123456789',
            'email' => 'jo@Jo.com',
            'password' => 'passwordz12',
        ]);

        $this->assertRegExp('~^/users/\d+$~', $response->toArray()['id']);
        $this->assertMatchesResourceItemJsonSchema(User::class);
    }

}