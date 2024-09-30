<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\OrderResource;
use App\Http\Requests\PaymentRequest\StorePaymentRequest;
use App\Http\Requests\PaymentRequest\UpdatePaymentRequest;

class PaymentController extends Controller
{
    /**
     * @var PaymentService
     */
    protected $paymentService;

    /**
     * PaymentController constructor.
     *
     * @param PaymentService $paymentService
     */
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Display a listing of all payments.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {

            $payments = $this->paymentService->getAllPayments();
            return response()->json(['data' => $payments], 200);

    }

    /**
     * Store a newly created payment in storage.
     *
     * @param StorePaymentRequest $request
     * @return JsonResponse
     */
    public function store(StorePaymentRequest $request): JsonResponse
    {

            $payment = $this->paymentService->createPayment($request->validated());
            return response()->json(['data' => $payment], 201);

    }

     /**
     * Display the specified payment.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
            $payment = $this->paymentService->getPaymentById($id);
            return response()->json(['data' => $payment], 200);

    }

    /**
     * Update the specified payment in storage.
     *
     * @param UpdatePaymentRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdatePaymentRequest $request, int $id): JsonResponse
    {

            $payment = $this->paymentService->updatePayment($id, $request->validated());
            return response()->json(['data' => $payment], 200);

    }

     /**
     * Remove the specified Payment from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $Payment = $this->paymentService->getPaymentById($id);
        $destroyPayment= $this->paymentService->deletePayment($Payment);
        return response()->json([
            'data' => $destroyPayment,
            'message' => 'Delete Payment successfully!'], 201);
    }

    /**
     * Restore a soft-deleted Payment.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function restore($id): JsonResponse
    {

            $this->paymentService->restorePayment($id);
            return response()->json(['message' => 'Payment restored successfully'], 200);

    }

    /**
     * Permanently delete Payment.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function forceDestroy($id): JsonResponse
    {
            $this->paymentService->forceDestroyPayment($id);
            return response()->json(['message' => 'Payment  permanently deleted'], 200);

    }
    /**
     * Get the soft-deleted projects.
     *
     * @return JsonResponse
     */
    public function getSoftDeletedPayment()
    {
        $Payment = Payment::onlyTrashed()->get();

        if ($Payment->isEmpty()) {
            return response()->json(['message' => 'No soft-deleted Payment found'], 404);
        }

        return response()->json($Payment, 200);
    }
}
