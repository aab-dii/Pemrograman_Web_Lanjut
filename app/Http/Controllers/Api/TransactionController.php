<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Http\Resources\TransactionsResource;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $transactions = Transaction::latest()->paginate(5);
        return new TransactionsResource(true, 'List Data Transactions', $transactions);
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'       => 'required|integer|exists:products,id',
            'transaction_type' => 'required|in:penambahan,penjualan',
            'quantity'         => 'required|integer',
            'date'             => 'required|date',
            'user_id'          => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $transaction = Transaction::create([
            'product_id'       => $request->product_id,
            'transaction_type' => $request->transaction_type,
            'quantity'         => $request->quantity,
            'date'             => $request->date,
            'user_id'          => $request->user_id,
        ]);

        return new TransactionsResource(true, 'Data Transaction Berhasil Ditambahkan!', $transaction);
    }

    /**
     * show
     *
     * @param mixed $id
     * @return void
     */
    public function show($id)
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }
        return new TransactionsResource(true, 'Detail Data Transaction!', $transaction);
    }

    /**
     * update
     *
     * @param Request $request
     * @param mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'product_id'       => 'required|integer|exists:products,id',
            'transaction_type' => 'required|in:penambahan,penjualan',
            'quantity'         => 'required|integer',
            'date'             => 'required|date',
            'user_id'          => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $transaction->update([
            'product_id'       => $request->product_id,
            'transaction_type' => $request->transaction_type,
            'quantity'         => $request->quantity,
            'date'             => $request->date,
            'user_id'          => $request->user_id,
        ]);

        return new TransactionsResource(true, 'Data Transaction Berhasil Diupdate!', $transaction);
    }

    /**
     * destroy
     *
     * @param mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        $transaction->delete();
        return new TransactionsResource(true, 'Data Transaction Berhasil Dihapus!', null);
    }
}


// namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

// class TransactionController extends Controller
// {
//     //
// }
