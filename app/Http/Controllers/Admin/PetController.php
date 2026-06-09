<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index(Request $request)
    {
        $query = Pet::with('user')->orderBy('name');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('name', 'ilike', "%$s%")
                  ->orWhere('breed', 'ilike', "%$s%")
                  ->orWhereHas('user', function($uq) use ($s) {
                      $uq->where('name', 'ilike', "%$s%");
                  });
            });
        }

        $pets = $query->paginate(10);
        return view('admin.pet.index', compact('pets'));
    }

    public function destroy($id)
    {
        $pet = Pet::findOrFail($id);
        $pet->delete();
        return back()->with('success', 'Pet removed from system.');
    }
}
