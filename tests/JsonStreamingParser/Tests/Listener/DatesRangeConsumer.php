<?php

namespace JsonStreamingParser\Tests\Listener;

use JsonStreamingParser\Listener\SubsetConsumer;

class DatesRangeConsumer extends SubsetConsumer
{

    public $dateRanges = array();

    /**
     * @param mixed $data
     *
     * @return boolean if data was consumed
     */
    protected function consume($data)
    {
        if (is_array($data) && array_key_exists('startDate', $data) && array_key_exists('endDate', $data)) {
            $this->dateRanges[] = $data;
            return true;
        }
        return false;
    }
}