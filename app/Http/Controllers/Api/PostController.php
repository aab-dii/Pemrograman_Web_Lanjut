<?php

namespace App\Http\Controllers\Api;

//use App\Http\Controllers\Controller;

//import model Post
use App\Models\Post;

use App\Http\Controllers\Controller;

//import resource PostResource
use App\Http\Resources\PostResource;

//import Http request
use Illuminate\Http\Request;

//import facade Validator
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Environment\Console;

//import facade Storage
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Log;

class PostController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    // berhasil
    public function index()
    {
        //get all posts
        $posts = Post::latest()->paginate(5);

        //return collection of posts as a resource
        return new PostResource(true, 'List Data Posts', $posts);
    }

    //berhasil
    public function store(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'     => 'required',
            'content'   => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Store the image in storage/app/public/posts
            $imagePath = $image->store('posts', 'public');
            // Get only the filename without 'posts/' path
            $filename = basename($imagePath);
        } else {
            return response()->json(['error' => 'Image upload failed'], 500);
        }

        // Create post with only the filename saved in the database
        $post = Post::create([
            'image'     => $filename, // Stores only the filename
            'title'     => $request->title,
            'content'   => $request->content,
        ]);

        // Return response
        return new PostResource(true, 'Data Post Berhasil Ditambahkan!', $post);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    //berhasil
    public function show($id)
    {
        //find post by ID
        $post = Post::find($id);

        //return single post as a resource
        return new PostResource(true, 'Detail Data Post!', $post);
    }


    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */

    // update (berhasil)
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }
    
        // Validasi input
        $validator = Validator::make($request->all(), [
            'image'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'     => 'required|string',
            'content'   => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        // Jika gambar baru diunggah, hapus gambar lama
        if ($request->hasFile('image')) {
            // Log path untuk memastikan file ada
            Log::info('Attempting to delete image for update: ' . 'posts/' . $post->image);
            $oldimagename = basename($post->image);
            Log::info('real name old image update: ' . 'posts/' . $oldimagename);
            
            if ($post->image && Storage::disk('public')->exists('posts/' . $oldimagename)) {
                Storage::disk('public')->delete('posts/' . $oldimagename);
                Log::info('Image deleted successfully for update: ' . $post->image . ' or ' . $oldimagename);
            }
    
            // Upload gambar baru
            $image = $request->file('image');
            $imagePath = $image->store('posts', 'public');
            $post->image = basename($imagePath);
        }
    
        // Update judul dan konten
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();
    
        return new PostResource(true, 'Data Post Berhasil Diupdate!', $post);
    }
    
    

    // delete (berhasil)
    public function destroy($id)
    {
        // Find post by ID
        $post = Post::find($id);
    
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }
    
        // Delete image if exists
        Log::info('Attempting to delete image for delete: ' . 'posts/' . $post->image);
        $oldimagename = basename($post->image);
        Log::info('real name old image delete: ' . 'posts/' . $oldimagename);
        
        if ($post->image && Storage::disk('public')->exists('posts/' . $oldimagename)) {
            Storage::disk('public')->delete('posts/' . $oldimagename);
            Log::info('Image deleted successfully for delete: ' . $post->image . ' or ' . $oldimagename);
        }
        // Delete post from database
        $post->delete();
    
        return new PostResource(true, 'Data Post Berhasil Dihapus!', null);
    }
    
}