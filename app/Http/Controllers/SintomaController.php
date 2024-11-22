<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSintomaRequest;
use App\Http\Requests\UpdateSintomaRequest;
use App\Http\Resources\SintomaResource;

use Illuminate\Http\Request;

use App\Models\Sintoma;

class SintomaController extends Controller
{
    
    public function index()
    {
        $sintomas = Sintoma::all();
        return SintomaResource::collection($sintomas);
    }

    public function store(StoreSintomaRequest $request)
    {
        $data = $request->validated();

        $sintoma = Sintoma::create($data);

        return response(new SintomaResource($sintoma), 201);

    }

    public function show(Sintoma $sintoma)
    {
        return new SintomaResource($sintoma);
    }

    public function update(UpdateSintomaRequest $request, Sintoma $sintoma)
    {
        $data = $request->validated();

        $sintoma->update($data);

        return new SintomaResource($sintoma);

    }

    public function destroy(Sintoma $sintoma)
    {
        $sintoma->delete();

        return response('', 204);
    }




}
