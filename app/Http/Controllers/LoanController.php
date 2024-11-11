<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function createLoan(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'lender_id' => 'required|exists:users,id',
            'borrower_id' => 'required|exists:users,id',
        ]);

        $loan = Loan::create($validated);

        return response()->json(['message' => 'Loan created successfully', 'loan' => $loan], 201);
    }

    public function index()
    {
        $loans = Loan::all();

        return response()->json($loans, 200);
    }

    public function approve($id)
    {
        $loan = Loan::findOrFail($id);
    
        // Check if the user is the lender and the loan is still pending
        if (auth()->user()->id === $loan->lender_id && $loan->status === Loan::STATUS_PENDING) {
            $loan->status = Loan::STATUS_APPROVED;
            $loan->save();
    
            return response()->json(['message' => 'Loan approved successfully', 'loan' => $loan], 200);
        }
    
        return response()->json(['message' => 'Unauthorized or invalid loan status'], 403);
    }

    public function destroy($id)
{
    $loan = Loan::findOrFail($id);

    // Check if the authenticated user is the lender of this loan
    if (auth()->user()->id !== $loan->lender_id) {
        return response()->json(['message' => 'Only the lender of this loan can delete it'], 403);
    }

    $loan->delete();

    return response()->json(['message' => 'Loan deleted successfully'], 200);
}

    public function update(Request $request, $id)
{
    $loan = Loan::findOrFail($id);

    // Check if the user is the lender of this loan
    if (auth()->user()->id !== $loan->lender_id) {
        return response()->json(['message' => 'Only the lender can update the loan details'], 403);
    }

    // Validate the incoming data for update
    $validated = $request->validate([
        'amount' => 'sometimes|numeric',
        'status' => 'sometimes|string|in:pending,approved,rejected', // You can add more statuses as needed
    ]);

    // Update the loan with the validated data
    $loan->update($validated);

    return response()->json(['message' => 'Loan updated successfully', 'loan' => $loan], 200);
}
}
