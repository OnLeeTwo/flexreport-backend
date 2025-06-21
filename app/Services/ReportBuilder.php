<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ReportBuilder
{
    public function build(string $table, array $columns, array $filters = [])
    {
        $query = DB::table($table)->select($columns);

        foreach ($filters as $column => $value) {
            if (is_array($value)) {
                $query->whereIn($column, $value);
            } else {
                $query->where($column, $value);
            }
        }

        return $query->get();
    }
}
