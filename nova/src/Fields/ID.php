<?php

namespace Laravel\Nova\Fields;

use Laravel\Nova\Http\Requests\NovaRequest;

class ID extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'id-field';

    /**
     * Create a new field.
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     * @param  mixed|null  $resolveCallback
     * @return void
     */
    public function __construct($name = null, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name ?? 'ID', $attribute, $resolveCallback);
    }

    /**
     * Create a new, resolved ID field for the given resource.
     *
     * @param  \Laravel\Nova\Resource  $resource
     * @return static
     */
    public static function forResource($resource)
    {
        $model = $resource->model();

        $methods = collect(['fieldsForIndex', 'fieldsForDetail'])
            ->filter(function ($method) use ($resource) {
                return method_exists($resource, $method);
            })->all();

        $field = transform(
            $resource->buildAvailableFields(app(NovaRequest::class), $methods)
                    ->whereInstanceOf(self::class)
                    ->first(),
            function ($field) use ($model) {
                return tap($field)->resolve($model);
            },
            function () use ($model) {
                return ! is_null($model) && $model->exists ? static::forModel($model) : null;
            }
        );

        return empty($field->value) && $field->nullable !== true ? null : $field;
    }

    /**
     * Create a new, resolved ID field for the given model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return static
     */
    public static function forModel($model)
    {
        return tap(static::make('ID', $model->getKeyName()))->resolve($model);
    }

    /**
     * Resolve a BIGINT ID field as a string for compatibility with JavaScript.
     *
     * @return $this
     */
    public function asBigInt()
    {
        $this->resolveCallback = function ($id) {
            return (string) $id;
        };

        return $this;
    }

    /**
     * Hide the ID field from the Nova interface but keep it available for operations.
     *
     * @return $this
     */
    public function hide()
    {
        $this->showOnIndex = false;
        $this->showOnDetail = false;
        $this->showOnCreation = false;
        $this->showOnUpdate = false;

        return $this;
    }
}
