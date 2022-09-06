<?php

/**
 * Modified: 2020-05-24T22:08:35+00:00
 */
namespace Office365\Common;

use Office365\Runtime\ClientValue;
class OptionalClaim extends ClientValue
{
    /**
     * @var string
     */
    public $Name;
    /**
     * @var string
     */
    public $Source;
    /**
     * @var bool
     */
    public $Essential;
    /**
     * @var array
     */
    public $AdditionalProperties;
}