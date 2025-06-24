<?php

public function build(string $table, array $columns, array $filters = [])
{
    $query = DB::table($table)->select($columns);

    foreach ($filters as $column => $value) {
        if (is_array($value)) {
            if (isset($value['range']) && is_array($value['range'])) {
                [$start, $end] = $value['range'] + [null, null];

                if ($start !== null) {
                    $query->where($column, '>=', $start);
                }
                if ($end !== null) {
                    $query->where($column, '<=', $end);
                }
            }

            // Handle "min" / "max" filter
            elseif (isset($value['min']) || isset($value['max'])) {
                if (isset($value['min'])) {
                    $query->where($column, '>=', $value['min']);
                }
                if (isset($value['max'])) {
                    $query->where($column, '<=', $value['max']);
                }
            }

            else {
                $query->whereIn($column, $value);
            }
        } else {
            $query->where($column, $value);
        }
    }

    return $query->get();
}
