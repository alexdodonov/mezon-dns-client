<?php

class DnsClientUnitTest extends \PHPUnit\Framework\TestCase
{

    /**
     * Common setup for all tests
     */
    public function setUp(): void
    {
        \Mezon\DnsClient\DnsClient::clear();
        \Mezon\DnsClient\DnsClient::setService('auth', 'auth.local');
        \Mezon\DnsClient\DnsClient::setService('author', 'author.local');
    }

    /**
     * Testing constructor
     */
    public function testGetServices(): void
    {
        // setup and test body
        $services = \Mezon\DnsClient\DnsClient::getServices();

        // assertions
        $this->assertEquals('auth, author', $services);
    }

    /**
     * Testing service existence
     */
    public function testServiceExists(): void
    {
        $this->assertTrue(\Mezon\DnsClient\DnsClient::serviceExists('auth'), 'Existing service was not found');

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
        \Mezon\DnsClient\DnsClient::resolveHost('unexisting');
    }

    /**
     * Testing resolving existing host
     */
    public function testResolveHost(): void
    {
        // test body and assertions
        $uRL = \Mezon\DnsClient\DnsClient::resolveHost('auth');
        $this->assertEquals('auth.local', $uRL, 'Invalid URL was fetched');
    }

    /**
     * Testing setService method
     */
    public function testSetService(): void
    {
        // setup and test body
        \Mezon\DnsClient\DnsClient::setService('service-name', 'http://example.com');

        // assertions
        $this->assertTrue(\Mezon\DnsClient\DnsClient::serviceExists('service-name'));
    }
}
