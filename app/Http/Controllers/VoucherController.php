<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vouchers\StoreRequest;
use App\Http\Requests\Vouchers\UpdateRequest;
use App\Models\Voucher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Voucher::where('user_id', Auth::id())->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        if (! Gate::allows('create-voucher')) {
            throw ValidationException::withMessages([
                'message' => 'Voucher limit of 10 has been exceeded. Please reduce the number of vouchers.'
            ]);
        }

        $data = array_merge($request->validated(), [
            'code' => $request->code ?? Str::random(5),
            'user_id' => Auth::id(),
        ]);

        try {
            $voucher = Voucher::create($data);

            return response()->json([
                'message' => 'Voucher created successfully.',
                'data' => $voucher,
            ]);
        } catch (\Throwable $th) {
            throw new Exception("There was an issue creating the voucher. Please try again later.");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $voucher = Voucher::find($id);

        if (! $voucher) {
            throw new NotFoundHttpException('No voucher found with the given ID.');
        }

        return response()->json([
            'message' => 'Voucher details retrieved successfully.',
            'data' => $voucher
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $voucher = Voucher::find($id);

        if (! $voucher) {
            throw new NotFoundHttpException('Voucher not found. Update could not be completed.');
        }

        try {
            $voucher->update($request->validated());

            return response()->json([
                'message' => 'Voucher updated successfully.',
                'data' => $voucher
            ]);
        } catch (\Throwable $th) {
            throw new Exception("There was an issue updating the voucher. Please try again later.");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $voucher = Voucher::find($id);

        if (! $voucher) {
            throw new NotFoundHttpException('Voucher not found. Deletion could not be completed.');
        }

        return response()->json(['message' => 'Voucher deleted successfully.']);
    }
}
