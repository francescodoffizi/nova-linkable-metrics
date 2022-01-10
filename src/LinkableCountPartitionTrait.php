<?php

namespace SaintSystems\Nova\LinkableMetrics;

trait LinkableCountPartitionTrait {
    use LinkableCount;

    /**
     * Create a new value metric result.
     *
     * @param  mixed  $value
     * @return LinkableCountPartitionResult
     */
    public function result($value)
    {
        $linkablePartitionResult = new LinkableCountPartitionResult($value);
        if (!empty($this->urls)) {
            $linkablePartitionResult->urls = $this->urls;
        }
        return $linkablePartitionResult;
    }
}