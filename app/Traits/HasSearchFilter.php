<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait HasSearchFilter
{
    /*public function scopeSearch($query, $keyword, array $columns = []): mixed
    {
        $keyword = str_replace(['\\', "\0", "\n", "\r", "'", '"', "\x1a"], ['\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'], $keyword); //ANTI INJECTION
        if (empty($columns)) {
            $columns = Arr::except(
                Schema::getColumnListing($this->table), $this->guarded
            );
        }
        $keywords = explode(' ', $keyword);
        $query->where(function ($query) use ($keywords, $columns) {
            foreach ($keywords as $key => $keyword) {
                $clause = $key == 0 ? 'where' : 'orWhere';

                $query->$clause(function ($query) use ($keyword, $columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'LIKE', "%$keyword%");
                    }
                });
            }
        });

        return $query;
//        $this->loopQuery('where', $query, $keyword, $columns);
//        $this->filterPerKeyWord($query, $keyword, $columns);
//
//        return $query;
    }

    private function loopQuery(string $status, $query, string $keyword, $columns): mixed
    {
        return $query->$status(function ($query) use ($keyword, $columns) {
            foreach ($columns as $key => $column) {
                $clause = $key == 0 ? 'where' : 'orWhere';
                $query->$clause($column, 'LIKE', "%$keyword%");
                //$query->orWhere(DB::raw("SOUNDEX($column)"), "=", soundex($keyword));
                $query->orWhereRaw("SOUNDEX($column) = SOUNDEX('$keyword')");
            }
        });
    }

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
    }*/

    public function scopeSearch($query, $keyword, array $columns = [])
    {
        $keyword = $this->escapeKeyword($keyword);

        $query = $this->filterPerKeyWord($query, $columns, $keyword);
        //$query = $this->addSoundexSearch($query, $columns, $keyword);

        return $query;
    }

    private function filterPerKeyWord($query, $columns, $keyword)
    {
        if (empty($columns)) {
            $columns = Arr::except(
                Schema::getColumnListing($this->table), $this->guarded
            );
        }

        $keywords = explode(' ', $keyword);
        $query->where(function ($query) use ($keywords, $columns) {
            foreach ($keywords as $key => $keyword) {
                $clause = $key == 0 ? 'where' : 'orWhere';

                $query->$clause(function ($query) use ($keyword, $columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'LIKE', "%$keyword%");
                    }
                });
            }
        });

        return $query;
    }

    private function addSoundexSearch($query, $columns, $keyword)
    {
        $keywords = explode(' ', $keyword);
        $query->orWhere(function ($query) use ($keywords, $columns) {
            foreach ($keywords as $key => $keyword) {
                $clause = $key == 0 ? 'where' : 'orWhere';

                $query->$clause(function ($query) use ($keyword, $columns) {
                    foreach ($columns as $column) {
                        $query->orWhereRaw("SOUNDEX($column) = SOUNDEX('$keyword')");
                    }
                });
            }
        });

        return $query;
    }

    private function escapeKeyword($keyword)
    {
        return str_replace(['\\', "\0", "\n", "\r", "'", '"', "\x1a"], ['\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'], $keyword);
    }

}
