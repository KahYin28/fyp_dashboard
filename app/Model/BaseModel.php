<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\QueryFilter;

class BaseModel extends Model
{
    protected $hidden = [
        'pivot'
    ];

    /**
     *
     * @param Model $query
     * @param number $number
     * @param string $sort
     * @param string $sortColumn
     * @param array $select
     * @return array $result
     */
    public function scopePageList($query, $number = 10, $sort = null, $sortColumn = null, $select = [])
    {
        if ($sortColumn != null && $sort != null) {
            $record = $query->orderBy($sortColumn, $sort)->paginate($number);
        } else {
            $record = $query->paginate($number);
        }

        $result = [];
        $result['data'] = $select ? $record->getCollection()->map(function ($row) use ($select) {
            return collect($row->toArray())->only($select)
                ->all();
        }) : $record->getCollection();
        $result['paging']['page'] = $record->currentPage();
        $result['paging']['per_page'] = (int)$number;
        $result['paging']['total'] = $record->total();
        $result['paging']['total_page'] = ceil($record->total() / $number);

        return $result;

    }

    /**
     * Custom model get function with field select input
     *
     * @param unknown $query
     * @param array $select
     * @return unknown
     */
    public function scopeCustomGet($query, $select = [])
    {
        $record = $query->get();

        if ($select) {
            return $record->map(function ($row) use ($select) {
                return collect($row->toArray())->only($select)
                    ->all();
            });
        }

        return $record;
    }

    /**
     *
     * @param unknown $query
     * @param array $select
     * @return unknown|array|number|mixed
     */
    public function scopeCustomFirstOrFail($query, $select = [])
    {
        $record = $query->firstOrFail();
        return $select ? collect($record->toArray())->only($select)->all() : $record;
    }

    public function scopeCustomFind($query, $id, $select = [])
    {
        $record = $query->find($id);
        return $select ? collect($record->toArray())->only($select)->all() : $record;
    }

    public function scopeCustomFirst($query, $select = [])
    {
        $record = $query->first();
        return $select ? collect($record->toArray())->only($select)->all() : $record;
    }

//    public function scopeCustomLast($query, $select = [])
//    {
//        $record = $query->last();
//        return $select ? collect($record->toArray())->only($select)->all() : $record;
//    }

    public function scopeCustomFindOrFail($query, $id, $select = [])
    {
        $record = $query->findOrFail($id);
        return $select ? collect($record->toArray())->only($select)->all() : $record;
    }

    /**
     * Filter a result set.
     *
     * @param
     *            $query
     * @param QueryFilter $filter
     * @return query
     */
    public function scopeFilter($query, QueryFilter $filter)
    {

        return $filter->apply($query);
    }

    /**
     * GOD MODE - DON'T UNCOMMENT!
     *
     * Allow to query other user information based on parameter pass by $user_id
     * else, by default it only return the query based on it own $user_id
     *
     * @param
     *            $query
     * @param int $user_id
     * @return mixed
     */
    public function scopeScope($query, $user_id = false)
    {
        if (!$user_id) {
            $user_id = auth()->user()->id;
        }

        $table = $this->getTable();

        $query->where(function ($query) use ($user_id, $table) {
            $query->whereRaw(\DB::raw('(' . $table . '.user_id = ' . $user_id . ')'));
        });

        return $query;
    }

    /**
     * Create a new model.
     *
     * @return \className
     */
    public static function createNew($user_id = false)
    {

        $className = get_called_class();
        $entity = new $className();

        if ($user_id) {
            $entity->user_id = $user_id;
        } elseif (auth()->check()) {
            $entity->user_id = auth()->user()->id;
        }

        return $entity;
    }
}
