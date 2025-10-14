<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\Student;
use DB;
use Log;

class PaymentController extends Controller
{
    /**
     * Check if student is authenticated and hasn't already subscribed
     */
    public function checkAuthentication(Request $request)
    {
        try {
            $courseId = $request->course_id;

            // Check if student is logged in
            if (!auth()->guard('student')->check()) {
                return response()->json([
                    'authenticated' => false,
                    'message' => 'Please login to continue'
                ]);
            }

            $studentId = auth()->guard('student')->user()->student_id;

            // Check if already subscribed
            $existingSubscription = Subscription::where('student_id', $studentId)
                                                ->where('course_id', $courseId)
                                                ->where('status', 1)
                                                ->first();

            if ($existingSubscription) {
                return response()->json([
                    'authenticated' => true,
                    'already_subscribed' => true,
                    'message' => 'You have already purchased this course'
                ]);
            }

            return response()->json([
                'authenticated' => true,
                'already_subscribed' => false
            ]);

        } catch (\Exception $e) {
            Log::error('Check Authentication Error: ' . $e->getMessage());
            return response()->json([
                'authenticated' => false,
                'message' => 'An error occurred'
            ], 500);
        }
    }

    /**
     * Create Stripe Checkout Session
     */
    public function createCheckoutSession(Request $request)
    {
        try {
            $courseId = $request->course_id;

            // Check if student is logged in
            if (!auth()->guard('student')->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to continue'
                ], 401);
            }

            $studentId = auth()->guard('student')->user()->student_id;
            $student = Student::find($studentId);
            $course = Course::findOrFail($courseId);

            // Determine the price to charge (discount rate or regular rate)
            $amount = $course->discount_rate && $course->discount_rate > 0 ? $course->discount_rate : $course->rate;

            // Convert amount to cents for Stripe (AED)
            $amountInCents = $amount * 100;

            // Check if Stripe class exists
            if (!class_exists('\Stripe\Stripe')) {
                Log::error('Stripe PHP library not found');
                return response()->json([
                    'success' => false,
                    'message' => 'Payment system is not configured properly. Please contact support.'
                ], 500);
            }

            // Set Stripe API key
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            // Create Stripe Checkout Session
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'aed',
                        'product_data' => [
                            'name' => $course->course_name,
                            'description' => strip_tags($course->description ?? 'Course Purchase'),
                        ],
                        'unit_amount' => $amountInCents,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('course-details', $courseId) . '?payment=cancelled',
                'client_reference_id' => $studentId . '_' . $courseId,
                'customer_email' => $student->email,
                'metadata' => [
                    'student_id' => $studentId,
                    'course_id' => $courseId,
                    'course_rate' => $course->rate,
                    'discount_rate' => $course->discount_rate,
                    'net_amount' => $amount
                ]
            ]);

            return response()->json([
                'success' => true,
                'checkout_url' => $session->url,
                'session_id' => $session->id
            ]);

        } catch (\Exception $e) {
            Log::error('Create Checkout Session Error: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create checkout session: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle Stripe Payment Success
     */
    public function paymentSuccess(Request $request)
    {
        try {
            $sessionId = $request->query('session_id');

            if (!$sessionId) {
                return redirect()->route('student.dashboard')->with('error', 'Invalid payment session');
            }

            // Set Stripe API key
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            // Retrieve the session from Stripe
            $session = \Stripe\Checkout\Session::retrieve($sessionId);

            // Check if payment was successful
            if ($session->payment_status !== 'paid') {
                return redirect()->route('student.dashboard')->with('error', 'Payment was not completed');
            }

            // Extract metadata
            $studentId = $session->metadata->student_id;
            $courseId = $session->metadata->course_id;
            $netAmount = $session->metadata->net_amount;
            $courseRate = $session->metadata->course_rate;

            // Check if this payment was already processed
            $existingPayment = Payment::where('payment_id', $session->payment_intent)->first();

            if ($existingPayment) {
                return redirect()->route('student.dashboard')->with('success', 'Course already purchased!');
            }

            // Get course details
            $course = Course::findOrFail($courseId);

            // Start database transaction
            DB::beginTransaction();

            try {
                // Store payment details
                $payment = Payment::create([
                    'student_id' => $studentId,
                    'course_id' => $courseId,
                    'referral_code' => null,
                    'referral_value' => null,
                    'course_rate' => $courseRate,
                    'net_amount' => $netAmount,
                    'payment_id' => $session->payment_intent,
                    'status' => 1,
                    'added_by' => $studentId
                ]);

                // Create subscription
                $subscription = Subscription::create([
                    'student_id' => $studentId,
                    'course_id' => $courseId,
                    'rate' => $courseRate,
                    'referral_code' => null,
                    'referral_value' => null,
                    'net_amount' => $netAmount,
                    'start_date' => $course->start_date,
                    'end_date' => $course->end_date,
                    'staff_id' => null,
                    'status' => 1,
                    'added_by' => $studentId
                ]);

                DB::commit();

                // Redirect to dashboard with success message
                return redirect()->route('student.dashboard')->with('success', 'Payment successful! You can now access the course.');

            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Payment Storage Error: ' . $e->getMessage());
                return redirect()->route('student.dashboard')->with('error', 'Payment received but failed to activate course. Please contact support.');
            }

        } catch (\Exception $e) {
            Log::error('Payment Success Handler Error: ' . $e->getMessage());
            return redirect()->route('student.dashboard')->with('error', 'An error occurred processing your payment');
        }
    }

    /**
     * Handle Stripe Payment Cancellation
     */
    public function paymentCancel()
    {
        return redirect()->route('courses')->with('info', 'Payment was cancelled. You can try again anytime.');
    }
}
