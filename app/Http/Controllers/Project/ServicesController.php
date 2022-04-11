<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServicesController extends Controller
{
    //
    public function index()
    {
        return view('project.service.index');
    }

    /**
     * fetch all services
     * @return JsonResponse
     */
    public function fetchServices(): JsonResponse
    {
        $services = Service::all();
        return response()->json([
            'data' => $services,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->validateRequest($request);
        $this->createService($request);
        return response()->json([
            'message' => 'Service created successfully'
        ]);
    }

    public function editService(Service $service): JsonResponse
    {
        return response()->json([
            'service' => $service
        ]);
    }

    // validate incoming request
    private function validateRequest($request)
    {
        $request->validate([
            'name' => 'required|unique:services,name',
        ], [
            'name.required' => 'Please enter a name',
            'name.unique' => 'Service name already taken',
        ]);
    }

    // create service record
    private function createService($request)
    {
        $service = new Service();
        $data = [
            'name' => $request['name'],
            'image_path' => $this->saveAnyImage($request)
        ];
        $service->create($data);
    }

    // create add image to services
    private function saveAnyImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return null;
        }
        return Storage::disk('public')->put('/images', $request->file('image'));
    }


    public function updateService(Request $request): JsonResponse
    {
        $this->validateEdit($request);
        $this->update($request);
        return response()->json([
            'message' => 'Service record updated successfully'
        ]);
    }


    // validate incoming request for edit
    private function validateEdit($request)
    {
        $request->validate([
            'editName' => 'required',
        ], [
            'editName.required' => 'Name cannot be empty'
        ]);
    }

    // update service model
    private function update($request)
    {
        $service = Service::find($request->serviceId);
        $service->update([
            'name' => $request['editName'],
            'image_path' => $this->updateAnyImage($request),
        ]);
    }

    // update and  add new image to service
    private function updateAnyImage(Request $request)
    {
        if (!$request->hasFile('editImage')) {
            return $request->existImage;
        }
        return Storage::disk('public')->put('/images', $request->file('editImage'));
    }

    /**
     * delete service
     * @param Service $service
     * @return JsonResponse
     */
    public function deleteService(Service $service): JsonResponse
    {
        $record = $service->product()->count();
        if ($record) {
            return response()->json([
                'status' => 400,
                'errors' => 'Sorry, service has existing products, you cannot delete'
            ]);
        } else {
            $service->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Service deleted successfully'
            ]);
        }


    }

}

