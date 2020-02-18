<?php
namespace Mezon\DnsClient;

/**
 * Class DnsClient
 *
 * @package Mezon
 * @subpackage DnsClient
 * @author Dodonov A.A.
 * @version v.1.0 (2019/08/15)
 * @copyright Copyright (c) 2019, aeon.org
 */

/**
 * DnsClient class for fetching data about services location
 *
 * For example the call DnsClient::resolveHost('example') will return URL of the example service
 */
class DnsClient
{

    /**
     * DNS records
     */
    public static $dNSRecords = [];

    /**
     * Method returns list of available services
     *
     * @return string List of services
     */
    public static function getServices(): string
    {
        return implode(', ', array_keys(self::$dNSRecords));
    }

    /**
     * Method returns true if the service was defined.
     *
     * @param string $serviceName
     *            Service name
     *            return bool Does service exists
     */
    public static function serviceExists(string $serviceName): bool
    {
        return isset(self::$dNSRecords[$serviceName]);
    }

    /**
     * Method resolves host
     *
     * @param string $serviceName
     *            Service name
     * @return string Service URL
     */
    public static function resolveHost(string $serviceName): string
    {
        if (! isset(self::$dNSRecords[$serviceName])) {
            throw (new \Exception(
                'Service "' . $serviceName . '" was not found among services: ' . self::getServices(),
                - 1));
        }

        if (is_string(self::$dNSRecords[$serviceName])) {
            return self::$dNSRecords[$serviceName];
        } else {
            throw (new \Exception('Invalid URL "' . serialize(self::$dNSRecords[$serviceName]) . '"', - 1));
        }
    }

    /**
     * Method saves service URL
     *
     * @param string $serviceName
     *            Service name
     * @param string $serviceUrl
     *            Service URL
     */
    public static function setService(string $serviceName, string $serviceUrl): void
    {
        self::$dNSRecords[$serviceName] = $serviceUrl;
    }

    /**
     * Method clears registry
     */
    public static function clear(): void
    {
        self::$dNSRecords = [];
    }
}
