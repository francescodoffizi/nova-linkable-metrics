<?php

namespace SaintSystems\Nova\LinkableMetrics;

trait LinkableCount
{
    use LinkableMultiple;

    /**
     * Create a new value metric count result’.
     *
     * @param  mixed  $value
     * @return \SaintSystems\Nova\LinkableMetrics\LinkableCountPartitionResult
     */
    public function result(array $value)
    {
        $linkablePartitionResult = new LinkableCountPartitionResult($value);
        if (!empty($this->urls)) {
            $linkablePartitionResult->urls($this->urls);
        }
        return $linkablePartitionResult;
    }
}