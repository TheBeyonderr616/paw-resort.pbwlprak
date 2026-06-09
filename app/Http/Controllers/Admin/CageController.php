<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cage;
use Illuminate\Http\Request;

class CageController extends Controller
{
    public function index(Request $request)
    {
        $query = Cage::orderBy('code');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('code', 'ilike', "%$s%")
                  ->orWhere('name', 'ilike', "%$s%");
            });
        }

        $cages = $query->paginate(15);
        
        // Stats for the monitor part
        $totalCages = Cage::count();
        $occupiedCount = Cage::where('status', 'occupied')->count();
        $availableCount = $totalCages - $occupiedCount;
        
        // for the JS grid (legacy compatibility if needed, but better to use pagination)
        $cageStates = Cage::orderBy('id')->pluck('status')->map(fn($s) => $s === 'occupied')->toArray();

        return view('admin.cage.index', compact('cages', 'totalCages', 'occupiedCount', 'availableCount', 'cageStates'));
    }

    public function create()
    {
        return view('admin.cage.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:cages,code',
            'name' => 'required|string',
            'type' => 'required|in:standard,vip',
        ]);

        Cage::create($request->all());

        return redirect()->route('admin.cage.index')->with('success', 'Cage created successfully!');
    }

    public function show($id)
    {
        $cage = Cage::with(['bookings.user', 'bookings.pet'])->findOrFail($id);
        return view('admin.cage.show', compact('cage'));
    }

    public function edit($id)
    {
        $cage = Cage::findOrFail($id);
        return view('admin.cage.edit', compact('cage'));
    }

    public function update(Request $request, $id)
    {
        $cage = Cage::findOrFail($id);

        $request->validate([
            'code' => 'required|string|unique:cages,code,' . $cage->id,
            'name' => 'required|string',
            'type' => 'required|in:standard,vip',
            'status' => 'required|in:available,occupied,locked',
        ]);

        $cage->update($request->all());

        return redirect()->route('admin.cage.index')->with('success', 'Cage updated successfully!');
    }

    public function destroy($id)
    {
        $cage = Cage::findOrFail($id);
        
        if ($cage->status === 'occupied') {
            return back()->with('error', 'Cannot delete an occupied cage!');
        }

        $cage->delete();
        return back()->with('success', 'Cage deleted successfully!');
    }
}
