<?php

namespace App\Http\Controllers;

use App\Models\ReportTemplate;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    // List all templates for the logged-in user
    public function index(Request $request)
    {
        $templates = $request->user()->reportTemplates()->get();

        return response()->json($templates);
    }

    // Store a new template for the logged-in user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'table_name' => 'required|string',
            'columns' => 'required|array',
            'filters' => 'nullable|array',
        ]);

        $template = $request->user()->reportTemplates()->create($validated);

        return response()->json($template, 201);
    }

    // Get a specific template by ID (if owned by user)
    public function show(Request $request, $id)
    {
        $template = $request->user()->reportTemplates()->findOrFail($id);

        return response()->json($template);
    }

    // Delete a template (optional)
    public function destroy(Request $request, $id)
    {
        $template = $request->user()->reportTemplates()->findOrFail($id);
        $template->delete();

        return response()->json(['message' => 'Template deleted']);
    }
}
