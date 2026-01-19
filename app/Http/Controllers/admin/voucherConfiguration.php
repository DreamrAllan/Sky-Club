<?php

namespace App\Http\Controllers\admin;

use App\Models\Voucher;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class voucherConfiguration extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $vouchers = Voucher::orderBy('created_at', 'desc')->get();
        return view('admin.voucher.voucher', compact('vouchers'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'expire_date' => 'required|date',
            'code' => 'required|string|max:255|unique:vouchers,code', // Validasi kode unik
            'quota' => 'required|integer',
            'discount_price_hidden' => 'nullable|integer', // Tipe data integer
            'discount_percentage_hidden' => 'nullable|integer', // Tipe data integer
            'max_discount_hidden' => 'nullable|integer', // Tipe data integer
            'min_price_hidden' => 'required|integer', // Tipe data integer
        ]);

        try {
            $voucher = new Voucher();
            $voucher->expire_date = $request->expire_date;
            $voucher->code = $request->code;
            $voucher->quota = $request->quota;
            $voucher->discount_price = $request->discount_price_hidden ?? 0; // Nilai default 0
            $voucher->discount_percentage = $request->discount_percentage_hidden ?? 0; // Nilai default 0
            $voucher->max_discount = $request->max_discount_hidden ?? 0; // Nilai default 0
            $voucher->min_price = $request->min_price_hidden;
            $voucher->save();

            return redirect()->back()->with('success', 'Voucher Created Successfully');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withErrors(['code' => 'The voucher code is already in use. Please use a different code.'])->withInput();
            }
            throw $e;
        }
    }


    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $request->validate([
            'expire_date' => 'required|date',
            'code' => 'required|string|max:6',
            'quota' => 'required|integer',
            'discount_price_hidden' => 'nullable|numeric',
            'discount_percentage_hidden' => 'nullable|numeric',
            'max_discount_hidden' => 'nullable|numeric',
            'min_price_hidden' => 'required|numeric',
        ]);

        try {
            $voucher = new Voucher();
            $voucher->expire_date = $request->expire_date;
            $voucher->code = $request->code;
            $voucher->quota = $request->quota;
            $voucher->discount_price = $request->discount_price_hidden ?? 0; // Nilai default 0
            $voucher->discount_percentage = $request->discount_percentage_hidden ?? 0; // Nilai default 0
            $voucher->max_discount = $request->max_discount_hidden ?? 0; // Nilai default 0
            $voucher->min_price = $request->min_price_hidden;
            $voucher->save();

            return redirect()->back()->with('success', 'Voucher Updated Successfully');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withErrors(['code' => 'The voucher code is already in use. Please use a different code.'])->withInput();
            }
            throw $e;
        }
    }

    public function destroy($id)
    {
        $voucher = Voucher::find($id);

        if ($voucher) {
            $voucher->delete();
            return redirect()->back()->with('success', 'Voucher Deleted Successfully');
        }

        return redirect()->back()->withErrors(['code' => 'Voucher Not Found']);
    }
}
