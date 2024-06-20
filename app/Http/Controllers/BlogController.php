<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Http\Facades\Validator;

class BlogController extends Controller
{
    // method will return all blogs
    public function index()
    {

    }
    //  return single blog
    public function show()
    {

    }
    //  stores blog
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required|min:10",
            "author" => "required|min:3"
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please fix the errors',
                'errors' => $validator->errors()
            ]);
        }
        $blog = new Blog();
        $blog->title = $request->title;
        $blog->author = $request->author;
        $blog->description = $request->description;
        $blog->shortDesc = $request->shortDesc;
        $blog->save();

        return response()->json([
            'status' => true,
            'message' => 'Blog added successfully.',
            'data' => $blog
        ]);

    }

    //  update blog
    public function update()
    {

    }
    //  delete blog
    public function destroy()
    {

    }
}
