<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Blog::all();
        return view('backend.content.blog.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.content.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
//        dd($request->all());
        $blog= new Blog();
        
        $blog->title= $request->title;
        $blog->slug= Str::slug($request->title);
        $blog->short_desc= $request->short_desc;
        $blog->long_desc= $request->long_desc;
        $blog->author= $request->author;
        $blog->meta_title= $request->meta_title;
        $blog->meta_desc= $request->meta_desc;
        $blog->meta_keyword= $request->meta_keyword;
       
        
        if ($request->hasFile('main_img')) {
            $file = $request->file('main_img');
            $extension = $file->getClientOriginalExtension();
            $filename = time() .uniqid() .'.' . $extension;
            $file->move('public/images/blog/', $filename);
            $blog->main_img ='public/images/blog/'. $filename;
        }
        if ($request->hasFile('multiple_img')) {
            $multiple_img=[];
            
            foreach ($request->file('multiple_img') as  $file) {
                $filename = time().uniqid().'.'.$file->getClientOriginalExtension();
                $file->move('public/images/blog/multiple', $filename);
                $multiple_img[]=$filename;
            }

            $blog->multiple_img = json_encode($multiple_img);
            
        }
        
        if ($request->hasFile('meta_image'))
        {
            $file = $request->file('meta_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() .uniqid() .'.' . $extension;
            $file->move('public/images/blog/meta/', $filename);
            $blog->meta_image = 'public/images/blog/meta/'.$filename;
        }
        
        
        
        $blog->save();
        
        return redirect()->route('admin.blogs.index')->with('message','Blog Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        return view('backend.content.blog.edit',compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
       

        $blog->title= $request->title;
        $blog->short_desc= $request->short_desc;
        $blog->long_desc= $request->long_desc;
        $blog->author= $request->author;
        $blog->meta_title= $request->meta_title;
        $blog->meta_desc= $request->meta_desc;
        $blog->meta_keyword= $request->meta_keyword;
        

        if ($request->hasFile('main_img')) {
            
            if ($blog->main_img && file_exists($blog->main_img)) {
                unlink($blog->main_img);
            }
            $file = $request->file('main_img');
            $extension = $file->getClientOriginalExtension();
            $filename = time() .uniqid() .'.' . $extension;
            $file->move('public/images/blog/', $filename);
            $blog->main_img = 'public/images/blog/'.$filename;
        }
        
        if ($request->hasFile('multiple_img')) {
            $multiple_img=[];

            foreach ($request->file('multiple_img') as  $file) {
                $filename = time().uniqid().'.'.$file->getClientOriginalExtension();
                $file->move('public/images/blog/multiple/', $filename);
                $multiple_img[]=$filename;
            }

            $blog->multiple_img = json_encode($multiple_img);

        }

        if ($request->hasFile('meta_image'))
        {
            $file = $request->file('meta_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() .uniqid() .'.' . $extension;
            $file->move('public/images/blog/meta/', $filename);
            $blog->meta_image = 'public/images/blog/meta/'.$filename;
        }



        $blog->update();
        
        return redirect()->back()->with('message','Blog Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        if ($blog->main_img && file_exists($blog->main_img)) {
            unlink($blog->main_img);
        }
        if ($blog->meta_image && file_exists($blog->meta_image)) {
            unlink($blog->meta_image);
        }
        return  redirect()->back()->with('message','Blog Deleted Successfully');
    }


    //    Upload in CkEditor
    public function uploadCkeditorImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('upload')->move(('public/images/blog/ckeditor'), $fileName);
        }

        return response()->json([
            'url' => asset('public/images/blog/ckeditor/'.$fileName), 'fileName' => $fileName,
            'uploaded' => 1
        ]);
    }
}
