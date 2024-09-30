<?php

namespace App\Services;

use Exception;
use Throwable;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentService
{

    /**
     * Retrieve all payments.
     *
     * @return Collection
     */
    public function getAllPayments(): Collection
    {
        try {
            return Payment::all();
        } catch (Exception $e) {
            Log::error('Error retrieving all payments: ' . $e->getMessage());
            throw new Exception('Failed to retrieve payments.');
        }
    }

    /**
     * Create a new payment.
     *
     * @param array $data
     * @return Payment
     * @throws Exception
     */
    public function createPayment(array $data): Payment
    {
        try {
            return Payment::create($data);
        } catch (Exception $e) {
            Log::error('Error creating payment: ' . $e->getMessage());
            throw new Exception('Failed to create payment.');
        }
    }

    /**
     * Retrieve a payment by its ID.
     *
     * @param int $id
     * @return Payment
     * @throws ModelNotFoundException
     */
    public function getPaymentById(int $id): Payment
    {
        try {
            return Payment::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Log::warning('Payment not found: ID ' . $id);
            throw $e;
        } catch (Exception $e) {
            Log::error('Error retrieving payment ID ' . $id . ': ' . $e->getMessage());
            throw new Exception('Failed to retrieve payment.');
        }
    }

    /**
     * Update an existing payment.
     *
     * @param int $id
     * @param array $data
     * @return Payment
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function updatePayment(int $id, array $data): Payment
    {
        try {
            $payment = Payment::findOrFail($id);
            $payment->update($data);
            return $payment;
        } catch (ModelNotFoundException $e) {
            Log::warning('Payment not found for update: ID ' . $id);
            throw $e;
        } catch (Exception $e) {
            Log::error('Error updating payment ID ' . $id . ': ' . $e->getMessage());
            throw new Exception('Failed to update payment.');
        }
    }
    /**
     * Delete a Payment.
     *
     * @param Payment $Payment
     * @return mixed
     * @throws Exception
     */
    public function deletePayment(Payment $Payment)
    {
        try {

            $Payment->delete();
        } catch (ModelNotFoundException $e) {
                return response()->json(['message' => 'Payment not found.'], 404);
        } catch (Exception $e) {
            Log::error('Error retrieving Payment with ID : ' . $e->getMessage());
            throw $e;
        }
    }
      /**
     * Restore a soft-deleted Payment
     *
     * @param int $id
     * @return void
     * @throws \Exception
     */
    public function restorePayment(int $id): void
    {
        try {
            $Payment = Payment::withTrashed()->findOrFail($id);
            $Payment->restore();

        } catch (Exception $e) {
            Log::error('Failed to restore Payment: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Permanently delete a Payment.
     *
     * @param int $id
     * @return void
     * @throws \Exception
     */
    public function forceDestroyPayment(int $id): void
    {
        try {
            $Order = Payment::withTrashed()->findOrFail($id);
            $Order->forceDelete();
        } catch (Exception $e) {
            Log::error('Failed to permanently delete Payment: ' . $e->getMessage());
            throw $e;
        }
    }

}
