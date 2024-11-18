<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vouchers\StoreRequest;
use App\Http\Requests\Vouchers\UpdateRequest;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => Voucher::where('user_id', Auth::id())->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = array_merge($request->validated(), [
            'code' => $request->code ?? Str::random(5),
            'user_id' => Auth::id(),
        ]);

        $voucher = Voucher::create($data);

        return response()->json([
            'data' => $voucher,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'data' => Voucher::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        return response()->json([
            'data' => $request->validated(),
        ]);

        $voucher = Voucher::findOrFail($id);
        $voucher->update($request->validated());

        return response()->json([
            'data' => $voucher,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $voucher = Voucher::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Successfully deleted voucher',
        ]);
    }
}
