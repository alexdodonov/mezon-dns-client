<?php
namespace Mezon\DnsClient\Tests;

use PHPUnit\Framework\TestCase;
use Mezon\DnsClient\DnsClient;

/**
 *
 * @author gdever
 * @psalm-suppress PropertyNotSetInConstructor
 */
class DnsClientUnitTest extends TestCase
{

    /**
     * Common setup for all tests
     */
    public function setUp(): void
    {
        DnsClient::clear();
        DnsClient::setService('auth', 'auth.local');
        DnsClient::setService('author', 'author.local');
    }

    /**
     * Testing constructor
     */
    public function testGetServices(): void
    {
        // setup and test body
        $services = DnsClient::getServices();

        // assertions
        $this->assertEquals('auth, author', $services);
    }

    /**
     * Testing service existence
     */
    public function testServiceExists(): void
    {
        $this->assertTrue(DnsClient::serviceExists('auth'), 'Existing service was not found');

        $this->assertFalse(\Mezon\DnsClient\DnsClient::serviceExists('unexisting'), 'Unexisting service was found');
    }

    /**
     * Testing resolving unexisting host
     */
    public function testResolveUnexistingHost(): void
    {
        // setup
        $this->expectException(\Exception::class);

        // test body and assertions
        DnsClient::resolveHost('unexisting');
    }

    /**
     * Testing resolving existing host
     */
    public function testResolveHost(): void
    {
        // test body and assertions
        $uRL = DnsClient::resolveHost('auth');
        $this->assertEquals('auth.local', $uRL, 'Invalid URL was fetched');
    }

    /**
     * Testing setService method
     */
    public function testSetService(): void
    {
        // setup and test body
        DnsClient::setService('service-name', 'http://example.com');

        // assertions
        $this->assertTrue(DnsClient::serviceExists('service-name'));
    }
}
