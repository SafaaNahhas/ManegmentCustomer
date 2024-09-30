<?php

namespace App\Services;

use Exception;
use Throwable;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomerService
{

    /**
     * Get all customers with their payments.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCustomersWithPayments()
    {
                return Customer::with(['latestPayment', 'oldestPayment', 'highestPayment', 'lowestPayment'])->get();

    }

    /**
     * Get a customer by ID with payment details.
     *
     * @param int $id
     * @return Customer
     * @throws ModelNotFoundException
     */
    public function getCustomerById(int $id): Customer
    { try {
        return Customer::with('payments')->findOrFail($id);
    } catch (ModelNotFoundException $e) {
        return response()->json(['message' => 'Customer not found.'], 404);
    } catch (\Exception $e) {
        Log::error('Error fetching customer: ' . $e->getMessage());
        return response()->json(['message' => 'An error occurred while fetching the customer.'], 500);
    }
    }

    /**
     * Create a new customer.
     *
     * @param array $data
     * @return Customer
     */
    public function createCustomer(array $data): Customer
    {try {
        return Customer::create($data);
    } catch (\Exception $e) {
        Log::error('Error creating customer: ' . $e->getMessage());
        return response()->json(['message' => 'An error occurred while creating the customer.'], 500);
    }
    }

    /**
     * Update an existing customer.
     *
     * @param int $id
     * @param array $data
     * @return Customer
     * @throws ModelNotFoundException
     */
    public function updateCustomer(int $id, array $data): Customer
    { try {
        $customer = Customer::findOrFail($id);
        $customer->update($data);
        return $customer;
    } catch (ModelNotFoundException $e) {
        return response()->json(['message' => 'Customer not found.'], 404);
    } catch (\Exception $e) {
        Log::error('Error updating customer: ' . $e->getMessage());
        return response()->json(['message' => 'An error occurred while updating the customer.'], 500);
    }
    }


 /**
     * Delete a Customer.
     *
     * @param Customer $Customer
     * @return mixed
     * @throws Exception
     */
    public function deleteCustomer(Customer $Customer)
    {
        try {
            $Customer->orders()->delete();
            $Customer->payments()->delete();
            $Customer->delete();
        } catch (ModelNotFoundException $e) {
                return response()->json(['message' => 'Customer not found.'], 404);
        } catch (Exception $e) {
            Log::error('Error retrieving Customer with ID : ' . $e->getMessage());
            throw $e;
        }
    }
      /**
     * Restore a soft-deleted Customer
     *
     * @param int $id
     * @return void
     * @throws \Exception
     */
    public function restoreCustomer(int $id): void
    {
        try {
            $Customer = Customer::withTrashed()->findOrFail($id);
            $Customer->restore();
            $Customer->orders()->restore();
            $Customer->payments()->restore();
        } catch (Exception $e) {
            Log::error('Failed to restore Customer: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Permanently delete a Customer
     *
     * @param int $id
     * @return void
     * @throws \Exception
     */
    public function forceDestroyCustomer(int $id): void
    {
        try {
            $Customer = Customer::withTrashed()->findOrFail($id);
            $Customer->orders()->forceDelete();
            $Customer->payments()->forceDelete();
            $Customer->forceDelete();
        } catch (Exception $e) {
            Log::error('Failed to permanently delete Customer: ' . $e->getMessage());
            throw $e;
        }
    }
    /**
     * Filter customers by Orders status.
     *
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function filterCustomersByOrdersStatus(string $status)
{
    try {
        return Customer::whereHas('orders', function($query) use ($status) {
            $query->where('status', $status);
        })->with('payments')->get();
    } catch (Exception $e) {
        Log::error('Error fetching customers by orders status: ' . $e->getMessage());
        throw new Exception('Failed to fetch customers by orders status.');
    }
}

    /**
     * Filter customers by Order date range.
     *
     * @param string $startDate
     * @param string $endDate
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function filterCustomersByOrderDateRange(string $startDate, string $endDate)
    {
        try {
            return Customer::whereHas('orders', function($query) use ($startDate, $endDate) {
                $query->whereBetween('order_date', [$startDate, $endDate]);
            })->with('orders')->get();
        } catch (Exception $e) {
            Log::error('Error fetching customers by order date range: ' . $e->getMessage());
            throw new Exception('Failed to fetch customers by order date range.');
        }
    }

}

