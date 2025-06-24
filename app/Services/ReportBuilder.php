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
                // Handle "range"
                if (isset($value['range']) && is_array($value['range'])) {
                    [$start, $end] = $value['range'] + [null, null];
                    if ($start !== null) $query->where($column, '>=', $start);
                    if ($end !== null) $query->where($column, '<=', $end);
                }
                // Handle min/max
                elseif (isset($value['min']) || isset($value['max'])) {
                    if (isset($value['min'])) $query->where($column, '>=', $value['min']);
                    if (isset($value['max'])) $query->where($column, '<=', $value['max']);
                }
                // whereIn fallback
                else {
                    $query->whereIn($column, $value);
                }
            } else {
                $query->where($column, $value);
            }
        }

        return $query->get();
    }
}
