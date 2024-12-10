<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductsResource;

class TransactionProductsController extends Controller
{
    /**
     * Mengambil semua produk dari database
     */
    public function index()
    {
        try {
            $products = Product::latest()->get();

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diambil',
                'data' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching products: ' . $e->getMessage()
            ], 500);
        }
    }
}
