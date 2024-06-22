<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Http\Facades\Validator;

class BlogController extends Controller
{
    // method will return all blogs
    public function index()
    {
        $blogs = Blog::orderBy("created_at", "DESC")->get();
        return response()->json([
            'status' => true,
            'data' => $blogs

        ]);
    }
    //  return single blog
    public function show($id)
    {
        $blog = Blog::find($id);
        if ($blog == null) {
            return response()->json([
                'status' => false,
                'message' => 'Blog not Found.',
            ]);
        }

        $blog['date'] = \Carbon\Carbon::parse($blog->created_at)->format(('d M,Y'));

        return response()->json([
            'status' => true,
            'data' => $blog,

        ]);

    }
    //  stores blog
    public function store(Request $request)
    {
        // import Validatot type Facades
        $validator = Validator::make($request->all(), [
            "title" => "required",
            "author" => "required"
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

        // Save Image Here
        $tempImage = TempImage::find($request->image_id);
        if ($tempImage != null) {
            // 564544456.jpg  only get the 'jpg' extension
            $imageExtArray = explode('.', $tempImage->name);
            $ext = last($imageExtArray);
            $imageName = time() . '-' . $blog->id . '.' . $ext;

            $blog->image = $imageName;
            $blog->save();

            $sourcePath = public_path('uploads/temp/' . $tempImage->name);
            $desPath = public_path('uploads/blogs/' . $tempImage);
            File::copy($sourcePath, $desPath);//import File using type Facades auto suggestions
        }
        return response()->json([
            'status' => true,
            'message' => 'Blog added successfully.',
            'data' => $blog
        ]);

    }

    //  update blog
    public function update($id, Request $request)
    {

        $blog = Blog::find($id);
        if ($blog == null) {
            return response()->json([
                'status' => false,
                'message' => 'Blog not found',
            ]);
        }

        $validator = Validator::make($request->all(), [
            "title" => "required",
            "author" => "required"
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please fix the errors',
                'errors' => $validator->errors()
            ]);
        }

        $blog->title = $request->title;
        $blog->author = $request->author;
        $blog->description = $request->description;
        $blog->shortDesc = $request->shortDesc;
        $blog->save();

        // Save Image Here
        $tempImage = TempImage::find($request->image_id);
        if ($tempImage != null) {
            // delete old image here
            File::delete(public_path('uploads/blogs/' . $blog->image));

            // 564544456.jpg  only get the 'jpg' extension
            $imageExtArray = explode('.', $tempImage->name);
            $ext = last($imageExtArray);
            $imageName = time() . '-' . $blog->id . '.' . $ext;

            $blog->image = $imageName;
            $blog->save();

            $sourcePath = public_path('uploads/temp/' . $tempImage->name);
            $desPath = public_path('uploads/blogs/' . $tempImage);
            File::copy($sourcePath, $desPath);//import File using type Facades auto suggestions
        }
        return response()->json([
            'status' => true,
            'message' => 'Blog updated successfully.',
            'data' => $blog
        ]);

    }

    //  delete blog
    public function destroy($id)
    {
        $blog = Blog::find($id)->delete();
        if ($blog == null) {

            return response()->json([
                'status' => false,
                'message' => 'Blog not Found',
            ]);
        }
        // Delete blog image first

        File::delete(public_path('uploads/blogs/' . $blog->image));
        $blog->delete();

        return response()->json([
    }
}
