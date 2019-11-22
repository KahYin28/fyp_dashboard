<?php
namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{

    /**
     * Default pagination limit
     */
    const PER_PAGE = 10;

    const SORT_BY = null;

    const SORT_TYPE = null;

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * The builder instance.
     *
     * @var Builder
     */
    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        foreach ($this->filters() as $name => $value) {
            if (! method_exists($this, $name)) {
                continue;
            }

            if ($this->request->has($name)) {
                $this->$name($value);
            } else {
                $this->$name();
            }
        }
        return $this->builder;
    }

    public function filters()
    {
        return $this->request->all();
    }

    public function perPage()
    {
        if ($this->request->has('per_page') && is_numeric($this->request->per_page)) {
            return $this->request->per_page;
        }
        return self::PER_PAGE;
    }

    public function sortType()
    {
        if ($this->request->has('sort_type')) {
            return $this->request->sort_type;
        }
        return self::SORT_TYPE;
    }

    public function sortBy()
    {
        if ($this->request->has('sort_by')) {
            return $this->request->sort_by;
        }
        return self::SORT_BY;
    }

    public function me()
    {
        return $this->builder->own();
    }

    public function addFilter($key, $value)
    {
        $this->request[$key] = $value;
    }

    public function removeFilter($key)
    {
        if ($this->request->has($key)) {
            unset($this->request[$key]);
        }
    }
}
