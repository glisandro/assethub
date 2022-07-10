<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Asset;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;

class AssetsController extends Controller
{
    public function redirect()
    {
        return redirect()->route('buildings.assets.index', Building::first()->id);
    }

    public function index(Building $building)
    {

        //Verificar si el building pertenece al usuario logeado, TODO: pasar eto a otro lado por ej middleware
        if(! Auth::user()->buildings()->find($building)->count()) {
            return redirect('/');
        }

        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                $query->where('name', 'LIKE', "%{$value}%");
                //TODO: cortar el string $value
                    //->orWhere('description', 'LIKE', "%{$value}%");
            });
        });

        $query = QueryBuilder::for(Asset::class);
        $query = $query->whereBelongsTo($building);

        $assets = $query
            ->defaultSort('name')
            ->allowedFilters(['name', 'description', 'status', $globalSearch]) // Los campos puestos en estos filtros deben estar en $table->addSearchRows
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Assets/Index', [
                'resources' => $assets,
                'building' => $building,
        ])->table(function (InertiaTable $table) {
            //Muestra u oculta columnas. No me gusta, no creo que lo vaya a usar para nada
            //$table->addColumn('name', 'Name');
            //Estos son los filtros por columna. Me gusta pero seria mejor mostrar u ocular todos con un solo click
            /* Lo deshabilito porque por el momento solo voy a usar la busqueda global*/
            /*$table->addSearchRows([
                'name' => 'Name',
                'description' => 'Description',
            ]);*/

            $table->addFilter('status', 'Status', [
                true => 'Enabled',
                false => 'Disabled',
            ]);
        });
    }

    public function edit(Building $building, Asset $asset)
    {
        $action = __FUNCTION__;

        return Inertia::render('Assets/Edit', compact('building', 'asset', 'action'));
    }

    public function update(Request $request, Building $building, Asset $asset)
    {
        //TODO: Validar que exista el building

        $this->validate($request, [
            'name' => 'required',
        ]);
        $asset->name = $request->input('name');
        $asset->description = $request->input('description');
        $asset->status = $request->input('status');
        $asset->save();

        return redirect()->route('buildings.assets.index', $building->id)->with('Saved'); //TODO:Redireccionar conservando el querystring
    }

    public function create(Building $building)
    {
        //TODO: Colicar un limite en la cantidad de assets para evitar Ej 1000000 para todos y 1000 para cuenats free
        $asset = new Asset();
        $action = __FUNCTION__;

        return Inertia::render('Assets/Edit', compact('building', 'asset', 'action'));
    }

    public function store(Request $request, Building $building)
    {
        //TODO: Validar que exista el building
        $asset = new Asset($this->validate($request, [
            'name' => 'required',
        ]));
        $asset->building_id = $building->id;
        $asset->description = $request->input('description'); // TODO: limpiar/codificar HTML?
        $asset->save();
        //dd($asset);
        return redirect()->route('buildings.assets.index', $building->id)->with('Created');
    }
}
