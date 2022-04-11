<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlanController extends Controller
{


    /**
     * view plan main page
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {


        return view('project.plan.index');

    }

    // fetch product for services
    public function fetchProduct(Service $service): JsonResponse
    {

        $products = $service->product()->get();
        return response()->json([
            'data' => $products,
        ]);
    }

    /**
     * fetch plans into landing page view
     * @return JsonResponse
     */
    // fetch plans
    public function fetchPlan(): JsonResponse
    {

        $plans = Plan::with('product.service')->get();
        return response()->json([
            'data' => $plans,
        ]);
    }

    /**
     * create new plan to product
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $this->validateRequest($request);
        $this->createPlan($request);
        return response()->json([
            'message' => 'Plan added successfully'
        ]);
    }


    // validate incoming request to create plan
    private function validateRequest($request)
    {
        $request->validate([
            'service' => 'required',
            'product' => 'required',
            'name' => 'required',
            'amount' => 'required',
        ], [
            'service.required' => 'Select Service',
            'product.required' => 'Select Product',
            'name.required' => 'Enter plan name',
            'amount.required' => 'Enter amount'
        ]);
    }

    // create plan
    private function createPlan($request)
    {
        $product = Product::find($request['product']);
        $product->plan()->create([
            'name' => $request['name'],
            'amount' => $request['amount'],
            'description' => $request['description'] ?? null,
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


    /**
     * show plan details on modal
     * @param Plan $plan
     * @return JsonResponse
     */
    public function editPlan(Plan $plan): JsonResponse
    {
        $data = $plan->fresh('product.service');
        return response()->json([
            'plan' => $data
        ]);
    }


    /**
     * update plan
     * @param Request $request
     * @param Plan $plan
     * @return JsonResponse
     */
    public function updatePlan(Request $request, Plan $plan): JsonResponse
    {

        $this->validateEdit($request);
        $this->update($request, $plan);
        return response()->json([
            'message' => 'Plan updated successfully'
        ]);
    }

    // validate incoming edit request
    private function validateEdit($request)
    {
        $request->validate([
            'editName' => 'required',
            'editAmount' => 'required',
        ], [
            'editName.required' => 'Plan name cannot empty',
            'editAmount.required' => 'Amount cannot be empty'
        ]);
    }

    // update plan
    private function update($request, $plan)
    {
        $plan->update([
            'name' => $request['editName'],
            'amount' => $request['editAmount'],
            'description' => $request['editDescription'],
            'image_path' => $this->updateImage($request),
        ]);
    }

    // update or add new image to plan
    private function updateImage(Request $request)
    {
        if (!$request->hasFile('editImage')) {
            return $request['editImage2'];
        }
        return Storage::disk('public')->put('/images', $request->file('editImage'));
    }


    /**
     * delete plan
     * @param Plan $plan
     * @return JsonResponse
     */
    public function deletePlan(Plan $plan): JsonResponse
    {
        $plan->delete();
        return response()->json([
            'message' => 'Plan deleted successfully'
        ]);

    }


}
