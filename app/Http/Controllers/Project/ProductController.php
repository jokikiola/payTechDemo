<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //

    public function index()
    {
        return view('project.product.index');
    }


    public function fetchProducts(): JsonResponse
    {
        $products = Product::with('service')->get();
        return response()->json([
            'data' => $products,
        ]);
    }


    /**
     * create new product
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $this->validateRequest($request);
        $this->createProduct($request);
        return response()->json([
            'message' => 'Product added successfully'
        ]);
    }

    public function editProduct(Product $product): JsonResponse
    {
        $product = $product->fresh('service');
        $services = Service::all();
        return response()->json([
            'product' => $product,
            'services' => $services,
        ]);
    }

    // update product record
    public function updateProduct(Request $request, Product $product): JsonResponse
    {
        $this->validateEdit($request);
        $this->update($request, $product);
        return response()->json([
            'message' => 'Product updated successfully'
        ]);

    }

    // validate product incoming request
    private function validateEdit($request)
    {
        $request->validate([
            'editName' => 'required'
        ],
            [
                'editName.required' => 'Product name cannot be empty'
            ]);
    }

    // update product record
    private function update($request, $product)
    {
        $product->update([
            'name' => $request['editName'],
            'image_path' => $this->updateImage($request),
        ]);
    }

    // validate incoming product request
    private function validateRequest($request)
    {
        $request->validate([
            'serviceId' => 'required',
            'name' => 'required|unique:products,name'
        ], [
            'serviceId.required' => 'Select service',
            'name.required' => 'Enter product name',
            'name.unique' => 'Product name already exist'
        ]);
    }

    // create product
    private function createProduct($request)
    {
        $service = Service::find($request['serviceId']);
        $service->product()->create([
            'name' => $request['name'],
            'image_path' => $this->saveAnyImage($request),
        ]);
    }

    // create add image to product
    private function saveAnyImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return null;
        }
        return Storage::disk('public')->put('/images', $request->file('image'));
    }

    // create add image to product
    private function updateImage(Request $request)
    {
        if (!$request->hasFile('editImage')) {
            return $request['existImage'];
        }
        return Storage::disk('public')->put('/images', $request->file('editImage'));
    }


    public function deleteProduct(Product $product)
    {
        $record = $product->plan()->count();

        if ($record) {
            return response()->json([
                'status' => 400,
                'errors' => 'Sorry, product has existing plan, you cannot delete'
            ]);
        } else {
            $product->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Product deleted successfully'
            ]);
        }

    }
}
