<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Building;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class BuildingsController extends Controller
{
    public function index()
    {
        
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                $query->where('name', 'LIKE', "%{$value}%");
            });
        });

        $query = QueryBuilder::for(Building::class);

        $buildings = $query
            //->allowedFields(['id', 'name'])
            ->withCount('assets')
            ->defaultSort('name')
            ->allowedSorts(['name'])
            ->allowedFilters(['name', $globalSearch])
            ->paginate()
            ->withQueryString();

        return Inertia::render('Buildings/Index', [
                'resources' => $buildings,
        ])->table();
    }

    public function edit(Building $building)
    {
        $action = __FUNCTION__;

        return Inertia::render('Buildings/Edit', compact('building', 'action'));
    }

    public function update(Request $request, Building $building)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $building->name = $request->input('name');
        $building->save();

        return redirect()->route('building.index')->with('Saved'); //TODO:Redireccionar conservando el querystring
    }

    public function create(Building $building)
    {
        //TODO: Colicar un limite en la cantidad de buildings para evitar mal uso Ej 100 para todos y 10000 para premium
        $action = __FUNCTION__;

        return Inertia::render('Buildings/EditOrNew', compact('building', 'action'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $building = new Building();
        $building->team_id = 1; //TODO:CAMBIAR
        $building->name = $request->input('name');
        $building->save();

        return redirect()->route('buildings.assets.index', $building->id)->with('Saved'); //TODO:Redireccionar conservando el querystring
    }
}
