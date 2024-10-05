<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCreateRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Products/Index', [
            'products' => Product::latest()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ProductCreateRequest $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCreateRequest $request): void
    {
        try {
            Product::create($request->validated());
            flashMessage('Successful', 'Product created successfully');
        } catch (Exception $e) {
            flashMessage('Error', 'Product creation failed', 'error');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductCreateRequest $request, Product $product): void
    {
        try {
            $product->update($request->validated());
            flashMessage('Successful', 'Product updated successfully');
        } catch (Exception $e) {
            flashMessage('Error', 'Product update failed', 'error');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): void
    {
        try {
            $product->delete();
            flashMessage('Successful', 'Product deleted successfully');
        } catch (Exception $e) {
            flashMessage('Error', 'Product deletion failed', 'error');
        }
    }
}
