<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait HasSearchFilter
{
    public function scopeSearch($query, $keyword, $columns = [], $relativeTables = [])
    {
        $keyword = str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $keyword); //ANTI INJECTION

        if (empty($columns)) {
            $columns = Arr::exept(
                Schema::getColumnListing($this->table), $this->guarded
            );
        }

        $this->loopQuery('where', $query, $keyword, $columns);

        $this->filterPerKeyWord($query, $keyword, $columns);

        return $query;
    }

    private function filterPerKeyWord($query, $keyword, $columns)
    {
        $arrValue = explode(' ', $keyword);
        if (count($arrValue) > 1) {
            foreach ($arrValue as $key => $keyword) {
                if ($key == 0) {
                    $status = 'orWhere';
                } else {
                    $status = 'where';
                }
                $this->loopQuery($status, $query, $keyword, $columns);
            }
            return $query;
        }

    }

    private function filterByRelationship($query, $keyword, $relativeTables)
    {
        foreach ($relativeTables as $relationship => $relativeColumns) {
            $query->orWhereHas($relationship, function($relationQuery) use ($keyword, $relativeColumns) {
                foreach ($relativeColumns as $key => $column) {
                    $clause = $key == 0 ? 'where' : 'orWhere';
                    $relationQuery->$clause($column, "LIKE", "%$keyword%");
                    $relationQuery->orWhere(DB::raw("SOUNDEX($column)"), "=", soundex($keyword));
                }
                $this->filterPerKeyWord($relationQuery, $keyword, $relativeColumns);
            });
        }

        return $query;
    }

    /**
     * @param string $status
     * @param $query
     * @param string $keyword
     * @param $columns
     * @return void
     */
    public function loopQuery(string $status, $query, string $keyword, $columns): void
    {
        $query->$status(function ($query) use ($keyword, $columns) {
            foreach ($columns as $key => $column) {
                $clause = $key == 0 ? 'where' : 'orWhere';
                $query->$clause($column, "LIKE", "%$keyword%");
                //$query->orWhere(DB::raw("SOUNDEX($column)"), "=", soundex($keyword));
                $query->orWhereRaw("SOUNDEX($column) = SOUNDEX('$keyword')");

                if (!empty($relativeTables)) {
                    $this->filterByRelationship($query, $keyword, $relativeTables);
                }
            }
        });
    }
}
