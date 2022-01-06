<?php

namespace SaintSystems\Nova\LinkableMetrics;

trait LinkableCount
{
    use LinkableMultiple;

    /**
     * Create a new value metric result.
     *
     * @param  mixed  $value
     * @return LinkableCountPartitionResult
     */
    public function result($value)
    {
        $linkableValueResult = new LinkableCountPartitionResult($value);
        if (!empty($this->url)) {
            $linkableValueResult->url($this->url);
        }
        return $linkableValueResult;
    }
}