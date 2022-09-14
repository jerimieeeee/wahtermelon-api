<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait HasSearchFilter
{
    /**
     * @param $query
     * @param $keyword
     * @param array $columns
     * @return mixed
     */
    public function scopeSearch($query, $keyword, array $columns = []): mixed
    {
        $keyword = str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $keyword); //ANTI INJECTION
        if (empty($columns)) {
            $columns = Arr::except(
                Schema::getColumnListing($this->table), $this->guarded
            );
        }
        $this->loopQuery('where', $query, $keyword, $columns);
        $this->filterPerKeyWord($query, $keyword, $columns);
        return $query;
    }

    /**
     * @param string $status
     * @param $query
     * @param string $keyword
     * @param $columns
     * @return mixed
     */
    private function loopQuery(string $status, $query, string $keyword, $columns): mixed
    {
        return $query->$status(function ($query) use ($keyword, $columns) {
            foreach ($columns as $key => $column) {
                $clause = $key == 0 ? 'where' : 'orWhere';
                $query->$clause($column, "LIKE", "%$keyword%");
                //$query->orWhere(DB::raw("SOUNDEX($column)"), "=", soundex($keyword));
                $query->orWhereRaw("SOUNDEX($column) = SOUNDEX('$keyword')");
            }
        });
    }

    /**
     * @param $keyword
     * @param $query
     * @param $columns
     * @return mixed
     */
    private function filterPerKeyWord($query, $keyword, $columns): mixed
    {
        $arrValue = explode(' ', $keyword);
        if (count($arrValue) > 1) {
            foreach ($arrValue as $key => $keyword) {
                $status = $key == 0 ? 'orWhere' : 'where';
                $this->loopQuery($status, $query, $keyword, $columns);
            }
        }
        return $query;
    }
}
