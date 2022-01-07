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
        if (!empty($this->urls)) {
            $linkableValueResult->url($this->urls);
        }
        return $linkableValueResult;
    }

    /**
     * Prepare the metric for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'urls' => $this->urls,
        ]);
    }
}