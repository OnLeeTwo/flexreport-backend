<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ReportBuilder;

class ReportController extends Controller
{
    public function getTables()
    {
        $tables = DB::select("SELECT tablename FROM pg_tables WHERE schemaname='public'");
        return response()->json(array_column($tables, 'tablename'));
    }

    public function getColumns($table)
    {
        $columns = DB::select("
            SELECT column_name, data_type
            FROM information_schema.columns
            WHERE table_name = ?", [$table]);

        return response()->json($columns);
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'table' => 'required|string',
            'columns' => 'required|array',
            'filters' => 'nullable|array',
            'format' => 'nullable|string'
        ]);

        $data = (new ReportBuilder)->build(
            $validated['table'],
            $validated['columns'],
            $validated['filters'] ?? []
        );

        return response()->json($data);
    }

    public function getColumnValues($table, $column)
    {
        // Basic validation for table and column names to avoid SQL injection
        if (!preg_match('/^\w+$/', $table) || !preg_match('/^\w+$/', $column)) {
            return response()->json(['error' => 'Invalid table or column name.'], 400);
        }

        try {
            $values = DB::table($table)
                ->select($column)
                ->distinct()
                ->whereNotNull($column)
                ->orderBy($column) // ✅ sort alphabetically/numerically
                ->limit(100)       // still limits to avoid heavy query
                ->pluck($column);

            return response()->json($values);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch values.'], 500);
        }
    }
}
