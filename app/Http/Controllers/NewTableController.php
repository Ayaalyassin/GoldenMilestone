<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class NewTableController extends Controller
{

    public function create()
    {
        return view('new-tabel');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'table_name' => 'required|string',
            'column_name' => 'required|array',
            'column_name.*' => 'string',
        ]);

        $tableName = $data['table_name'];
        $columnNames = $data['column_name'];

        // Create the table if it doesn't exist
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function ($table) use ($columnNames) {
                $table->id();
                foreach ($columnNames as $columnName) {
                    $table->string($columnName);
                }
                $table->timestamps();
            });
        }

        return redirect('/new-table')->with('success', 'Table created successfully!');
    }
}
