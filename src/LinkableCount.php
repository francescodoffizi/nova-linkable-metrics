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
        $linkableCountPartitionResult = new LinkableCountPartitionResult($value);
        if (!empty($this->urls)) {
            $linkableCountPartitionResult->url($this->urls);
        }
        return $linkableCountPartitionResult;
    }
}