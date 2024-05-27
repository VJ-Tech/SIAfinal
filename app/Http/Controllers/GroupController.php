<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use Inertia\Inertia;
use League\Csv\Reader;
use League\Csv\Statement;
use Barryvdh\DomPDF\Facade\Pdf;
class GroupController extends Controller
{
    public function store(Request $request)
{
    try {
        if (!$request->has('groups')) {
            return response()->json(['error' => 'No groups data provided'], 400);
        }

        $groupSet = Group::max('groupSet') + 1;

        foreach ($request->groups as $index => $group) {
            foreach ($group as $name) {
                Group::create([
                    'name' => $name,
                    'groupName' => 'Group ' . ($index + 1),
                    'groupSet' => $groupSet,
                ]);
            }
        }

        return response()->json(['message' => 'Groups saved successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function getAllGroups()
    {
        $groups = Group::orderBy('groupSet')->get();
        return response()->json($groups);
    }

    public function generatePDF()
    {
        $groups = Group::all();

        $pdf = PDF::loadView('pdf.groups', compact('groups'));
        return $pdf->download('groups.pdf');
    }
}


