<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyProductDivisionRequest;
use App\Http\Requests\StoreProductDivisionRequest;
use App\Http\Requests\UpdateProductDivisionRequest;
use App\Models\ProductDivision;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductDivisionController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('product_division_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productDivisions = ProductDivision::all();

        return view('admin.productDivisions.index', compact('productDivisions'));
    }

    public function create()
    {
        abort_if(Gate::denies('product_division_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.productDivisions.create');
    }

    public function store(StoreProductDivisionRequest $request)
    {
        $productDivision = ProductDivision::create($request->all());

        return redirect()->route('admin.product-divisions.index');
    }

    public function edit(ProductDivision $productDivision)
    {
        abort_if(Gate::denies('product_division_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.productDivisions.edit', compact('productDivision'));
    }

    public function update(UpdateProductDivisionRequest $request, ProductDivision $productDivision)
    {
        $productDivision->update($request->all());

        return redirect()->route('admin.product-divisions.index');
    }

    public function show(ProductDivision $productDivision)
    {
        abort_if(Gate::denies('product_division_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.productDivisions.show', compact('productDivision'));
    }

    public function destroy(ProductDivision $productDivision)
    {
        abort_if(Gate::denies('product_division_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productDivision->delete();

        return back();
    }

    public function massDestroy(MassDestroyProductDivisionRequest $request)
    {
        $productDivisions = ProductDivision::find(request('ids'));

        foreach ($productDivisions as $productDivision) {
            $productDivision->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
