<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Services\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\CustomerResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\CustomRequest\StoreCustomerRequest;
use App\Http\Requests\CustomRequest\FilterByStatusRequest;
use App\Http\Requests\CustomRequest\UpdateCustomerRequest;
use App\Http\Requests\CustomRequest\FilterByDateRangeRequest;

class CustomerController extends Controller
{

 /**
     * @var CustomerService
     */
    protected $customerService;

    /**
     * CustomerController constructor.
     *
     * @param CustomerService $customerService
     */
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Display a listing of all customers with their payments.
     *
     * @return JsonResponse
     */
    // public function index(Request $request): JsonResponse
    // {

    //         if ($request->has('status')) {
    //             $customers = $this->customerService->filterCustomersByPaymentStatus($request->input('status'));
    //         } if ($request->has(['start_date', 'end_date'])) {
    //             $customers = $this->customerService->filterCustomersByPaymentDateRange(
    //                 $request->input('start_date'),
    //                 $request->input('end_date')
    //             );
    //         }
    //             $customers = $this->customerService->getAllCustomersWithPayments();


    //         return response()->json( CustomerResource::collection($customers), 200);

    // }
    public function index(Request $request): JsonResponse
{

        $customers = $this->customerService->getAllCustomersWithPayments();
        return response()->json(CustomerResource::collection($customers), 200);

}

    /**
     * Store a newly created customer in storage.
     *
     * @param StoreCustomerRequest $request
     * @return JsonResponse
     */
    public function store(StoreCustomerRequest $request): JsonResponse
    {

            $customer = $this->customerService->createCustomer($request->validated());
            return response()->json(['data' => $customer],  201);

    }

    /**
     * Display the specified customer with payment details.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {

            $customer = $this->customerService->getCustomerById($id);
            return response()->json(new CustomerResource($customer), 200);

    }

    /**
     * Update the specified customer in storage.
     *
     * @param UpdateCustomerRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateCustomerRequest $request, int $id): JsonResponse
    {

            $customer = $this->customerService->updateCustomer($id, $request->validated());
            return response()->json(['data' => $customer], 200);

    }


     /**
     * Remove the specified Customer from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $Customer = $this->customerService->getCustomerById($id);
        $destroyCustomer= $this->customerService->deleteCustomer($Customer);
        return response()->json([
            'data' => $destroyCustomer,
            'message' => 'Delete Customer successfully!'], 201);
    }

    /**
     * Restore a soft-deleted Customer .
     *
     * @param int $id
     * @return JsonResponse
     */
    public function restore($id): JsonResponse
    {

            $this->customerService->restoreCustomer($id);
            return response()->json(['message' => 'Customer and its Orders and payments restored successfully'], 200);

    }

    /**
     * Permanently delete a Customer .
     *
     * @param int $id
     * @return JsonResponse
     */
    public function forceDestroy($id): JsonResponse
    {
            $this->customerService->forceDestroyCustomer($id);
            return response()->json(['message' => 'Customer and its Orders and payments  permanently deleted'], 200);

    }
    /**
     * Get the soft-deleted .
     *
     * @return JsonResponse
     */
    public function getSoftDeletedCustomer()
    {
        $Customer = Customer::onlyTrashed()->get();

        if ($Customer->isEmpty()) {
            return response()->json(['message' => 'No soft-deleted Customer found'], 404);
        }

        return response()->json($Customer, 200);
    }


    /**
     * Filter customers by Order status.
     *
     * @param FilterByStatusRequest $request
     * @return JsonResponse
     */
    public function filterByOrdersStatus(FilterByStatusRequest $request): JsonResponse
    {
        $status = $request->input('status');
        $customers = $this->customerService->filterCustomersByOrdersStatus($status);
        return response()->json(['data' => CustomerResource::collection($customers)], 200);

    }

    /**
     * Filter customers by  Order date range.
     *
     * @param FilterByDateRangeRequest $request
     * @return JsonResponse
     */

    public function filterByOrderDateRange(FilterByDateRangeRequest $request): JsonResponse
    {
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');
        $customers = $this->customerService->filterCustomersByOrderDateRange($startDate, $endDate);
        return response()->json(['data' => CustomerResource::collection($customers)], 200);

    }
}
