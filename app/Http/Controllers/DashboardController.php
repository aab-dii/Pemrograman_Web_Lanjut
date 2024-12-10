<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getLowStock()
    {
        $lowStock = DB::select('
            SELECT *
            FROM products
            WHERE stock <= 10
            ORDER BY stock ASC
            LIMIT 5
        ');

        return response()->json($lowStock);
    }

    public function getBestSellers()
    {
        $bestSellers = DB::select('
            SELECT p.stock, p.price, p.id, p.name, SUM(t.quantity) AS total_terjual
            FROM transactions t
            JOIN products p ON t.product_id = p.id
            WHERE t.transaction_type = "penjualan"
            GROUP BY p.id
            ORDER BY total_terjual DESC
            LIMIT 1
        ');

        return response()->json($bestSellers);
    }

    public function getTotalPenjualan()
    {
        $totalPenjualan = DB::select('
            SELECT SUM(t.quantity * p.price) AS total_penjualan
            FROM transactions t
            JOIN products p ON t.product_id = p.id
            WHERE t.transaction_type = "penjualan"
        ');

        return response()->json($totalPenjualan);
    }

    public function getTotalProducts()
    {
        $totalProducts = DB::select('
            SELECT COUNT(*) AS total_products
            FROM products
        ');

        return response()->json($totalProducts);
    }

    public function getOutOfStockProducts()
    {
        $outOfStockProducts = DB::select('
            SELECT COUNT(*) AS out_of_stock_products
            FROM products
            WHERE stock = 0
        ');

        return response()->json($outOfStockProducts);
    }
}