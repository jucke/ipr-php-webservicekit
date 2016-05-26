<?php

namespace BBC\iPlayerRadio\WebserviceKit\Tests\Stubs;

class Query extends \BBC\iPlayerRadio\WebserviceKit\Query
{
    protected $endpoint = 'webservicekit';

    public function __construct($endpoint = 'webservicekit')
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Returns the URL to query, with any parameters applied.
     *
     * @return  string
     */
    public function getURL()
    {
        return 'http://localhost/'.$this->endpoint;
    }

    /**
     * Returns a friendly (and safe) name of the webservice this query hits which we can use in
     * error logging and circuit breakers etc. [a-z0-9-_] please.
     */
    public function getServiceName()
    {
        return 'unit_tests';
    }

    /**
     * Given a response from the webservice, this function is called to transform it into something
     * a bit more useful for output.
     *
     * This may be passed a false or a null if the call to the webservice fails, so unit test appropriately.
     *
     * @param   mixed $response
     * @return  mixed
     */
    public function transformPayload($response)
    {
        return ($response)? json_decode($response) : $response;
    }
}
