<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\OrderResource;
use App\Http\Requests\OrderRequest\StoreOrderRequest;
use App\Http\Requests\OrderRequest\UpdateOrderRequest;
use App\Http\Requests\OrderRequest\GetOrdersByProductRequest;
use App\Http\Requests\OrderRequest\GetOrdersByCustomerRequest;

class OrderController extends Controller
{
 /**
     * The order service instance.
     *
     * @var OrderService
     */
    protected $orderService;

    /**
     * Create a new controller instance.
     *
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of all orders with optional filters.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $orders = $this->orderService->getAllOrders();
        return response()->json(OrderResource::collection($orders), 200);
    }

    /**
     * Store a newly created order in storage.
     *
     * @param StoreOrderRequest $request
     * @return JsonResponse
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {

            $order = $this->orderService->createOrder($request->validated());
            return response()->json(['data' => $order], 201);

    }

    /**
     * Display the specified order.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
            $order = $this->orderService->getOrderById($id);
            return response()->json(new OrderResource($order), 200);
            // return response()->json(['data' => $order], 200);

    }

    /**
     * Update the specified order in storage.
     *
     * @param UpdateOrderRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateOrderRequest $request, int $id): JsonResponse
    {

            $order = $this->orderService->updateOrder($id, $request->validated());
            return response()->json(['data' => $order], 200);

    }
     /**
     * Remove the specified Order from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $Order = $this->orderService->getOrderById($id);
        $destroyOrder= $this->orderService->deleteOrder($Order);
        return response()->json([
            'data' => $destroyOrder,
            'message' => 'Delete Order successfully!'], 201);
    }

    /**
     * Restore a soft-deleted Order.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function restore($id): JsonResponse
    {

            $this->orderService->restoreOrder($id);
            return response()->json(['message' => 'Order restored successfully'], 200);

    }

    /**
     * Permanently delete aOrder.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function forceDestroy($id): JsonResponse
    {
            $this->orderService->forceDestroyOrder($id);
            return response()->json(['message' => 'Order  permanently deleted'], 200);

    }
    /**
     * Get the soft-deleted projects.
     *
     * @return JsonResponse
     */
    public function getSoftDeletedOrder()
    {
        $Order = Order::onlyTrashed()->get();

        if ($Order->isEmpty()) {
            return response()->json(['message' => 'No soft-deleted Order found'], 404);
        }

        return response()->json($Order, 200);
    }

    /**
     * Display a listing of orders for a specific customer.
     *
     * @param int $customerId
     * @return JsonResponse
     */

    public function getOrdersByCustomer(GetOrdersByCustomerRequest $request): JsonResponse
    {
        $customerId = $request->input('customer_id');
        $orders = $this->orderService->getOrdersByCustomer($customerId);

        return response()->json(['data' => OrderResource::collection($orders)], 200);
    }
    /**
     * Display a listing of orders that contain a specific product.
     *
     * @param Request $request
     * @return JsonResponse
     */

public function getOrdersByProduct(GetOrdersByProductRequest $request): JsonResponse
{
    $productName = $request->input('product_name');
    $orders = $this->orderService->getOrdersByProductName($productName);

    return response()->json(['data' => OrderResource::collection($orders)], 200);
}
}

