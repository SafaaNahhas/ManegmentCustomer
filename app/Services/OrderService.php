<?php

namespace App\Services;

use Exception;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderService
{

      /**
     * Get all orders with related customer information.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllOrders()
    { try {
        return Order::with('customer')->get();
    } catch (\Exception $e) {
        Log::error('Error fetching orders: ' . $e->getMessage());
        return response()->json(['message' => 'Failed to fetch orders.'], 500);
    }
    }

    /**
     * Get a specific order by ID with related customer information.
     *
     * @param int $id
     * @return Order
     * @throws ModelNotFoundException
     */
    public function getOrderById(int $id): Order
    {        try {

        return Order::with('customer')->findOrFail($id);
    } catch (ModelNotFoundException $e) {
        return response()->json(['message' => 'Order not found.'], 404);
    } catch (\Exception $e) {
        Log::error('Error fetching order: ' . $e->getMessage());
        return response()->json(['message' => 'An error occurred while fetching the order.'], 500);
    }
    }

    /**
     * Create a new order.
     *
     * @param array $data
     * @return Order
     */
    public function createOrder(array $data): Order
    {  try {
        return Order::create($data);
    } catch (\Exception $e) {
        Log::error('Error creating order: ' . $e->getMessage());
        return response()->json(['message' => 'An error occurred while creating the order.'], 500);
    }
    }

    /**
     * Update an existing order.
     *
     * @param int $id
     * @param array $data
     * @return Order
     * @throws ModelNotFoundException
     */
    public function updateOrder(int $id, array $data): Order
    {  try {
        $order = Order::findOrFail($id);
        $order->update($data);
        return $order;
    } catch (ModelNotFoundException $e) {
        return response()->json(['message' => 'Order not found.'], 404);
    } catch (\Exception $e) {
        Log::error('Error updating order: ' . $e->getMessage());
        return response()->json(['message' => 'An error occurred while updating the order.'], 500);
    }
    }
    /**
     * Delete a Customer.
     *
     * @param Order $Order
     * @return mixed
     * @throws Exception
     */
    public function deleteOrder(Order $Order)
    {
        try {

            $Order->delete();
        } catch (ModelNotFoundException $e) {
                return response()->json(['message' => 'Order not found.'], 404);
        } catch (Exception $e) {
            Log::error('Error retrieving Order with ID : ' . $e->getMessage());
            throw $e;
        }
    }
      /**
     * Restore a soft-deleted Order
     *
     * @param int $id
     * @return void
     * @throws \Exception
     */
    public function restoreOrder(int $id): void
    {
        try {
            $Order = Order::withTrashed()->findOrFail($id);
            $Order->restore();

        } catch (Exception $e) {
            Log::error('Failed to restore Order: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Permanently delete a Order.
     *
     * @param int $id
     * @return void
     * @throws \Exception
     */
    public function forceDestroyOrder(int $id): void
    {
        try {
            $Order = Order::withTrashed()->findOrFail($id);
            $Order->forceDelete();
        } catch (Exception $e) {
            Log::error('Failed to permanently delete Order: ' . $e->getMessage());
            throw $e;
        }
    }
    /**
     * Get orders by a specific Order.
     *
     * @param int $customerId
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function getOrdersByCustomer(int $customerId)
    {
        try {
            return Order::with('customer')->where('customer_id', $customerId)->get();
        } catch (\Exception $e) {
            Log::error('Error fetching orders by customer: ' . $e->getMessage());
            throw new \Exception('Failed to fetch orders by customer.');
        }
    }
    /**
     * Get orders that contain a specific product name.
     *
     * @param string $productName
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function getOrdersByProductName(string $productName)
    {
        try {
            return Order::where('product_name', 'like', '%' . $productName . '%')->get();
        } catch (Exception $e) {
            Log::error('Error fetching orders by product name: ' . $e->getMessage());
            throw new Exception('Failed to fetch orders by product name.');
        }
    }
}
