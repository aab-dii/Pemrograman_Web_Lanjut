<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductsResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $products = Product::latest()->paginate(5);
        return new ProductsResource(true, 'List Data Products', $products);
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
            'image'    => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name'     => 'required|string',
            'category' => 'required|string',
            'price'    => 'required|integer',
            'stock'    => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('products', 'public');
            $filename = basename($imagePath);
        } else {
            return response()->json(['error' => 'Image upload failed'], 500);
        }

        $product = Product::create([
            'image'    => $filename,
            'name'     => $request->name,
            'category' => $request->category,
            'price'    => $request->price,
            'stock'    => $request->stock,
        ]);

        return new ProductsResource(true, 'Data Product Berhasil Ditambahkan!', $product);
    }

    /**
     * show
     *
     * @param mixed $id
     * @return void
     */
    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return new ProductsResource(true, 'Detail Data Product!', $product);
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
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'image'    => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name'     => 'required|string',
            'category' => 'required|string',
            'price'    => 'required|integer',
            'stock'    => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('image')) {
            Log::info('Attempting to delete image for update: ' . 'products/' . $product->image);
            $oldimagename = basename($product->image);
            if ($product->image && Storage::disk('public')->exists('products/' . $oldimagename)) {
                Storage::disk('public')->delete('products/' . $oldimagename);
                Log::info('Image deleted successfully for update: ' . $oldimagename);
            }

            $image = $request->file('image');
            $imagePath = $image->store('products', 'public');
            $product->image = basename($imagePath);
        }

        $product->name = $request->name;
        $product->category = $request->category;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->save();

        return new ProductsResource(true, 'Data Product Berhasil Diupdate!', $product);
    }

    /**
     * destroy
     *
     * @param mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        Log::info('Attempting to delete image for delete: ' . 'products/' . $product->image);
        $oldimagename = basename($product->image);
        if ($product->image && Storage::disk('public')->exists('products/' . $oldimagename)) {
            Storage::disk('public')->delete('products/' . $oldimagename);
            Log::info('Image deleted successfully for delete: ' . $oldimagename);
        }

        $product->delete();
        return new ProductsResource(true, 'Data Product Berhasil Dihapus!', null);
    }
}





// namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

// //import model Post
// use App\Models\Post;

// //import resource PostResource
// use App\Http\Resources\ProductsResource;

// class ProductsController extends Controller
// {
//     //
// }
