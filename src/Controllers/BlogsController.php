<?php

namespace Hosein\Blogs\Controllers;

use Hosein\Blogs\blogs;
use Illuminate\Support\Facades\Validator;

use Hosein\Blogs\categoryblogs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogsController extends Controller
{
    public function index($id=null){

        if($id==null||!is_numeric($id)){
            $data["id"]=0;
        }
        else{
            $data["id"]=$id;
        }
        $data["listCategory"]=$this->listCategory();
        $data["listBlog"]=$this->listBlogs();
        return view("BlogsView::blogs",$data);
    }
    public function createCategory(Request $request,$id){
        $validator=Validator::make($request->all(),[
            "name"=>'required|max:255|string'
        ]);
        if($validator->fails()){
            return redirect('blogs/'.$id)
                ->withErrors($validator,"category")
                ->withInput();
        }
        $this->setParentChild($id);
        $category=new categoryblogs();
        $category->name=$request->all()["name"];
        $category->parent=$id;
        $category->is_parent=0;
        $category->save();
        return redirect('blogs');
    }
    public function editCategory($cat,$id){
        $category=categoryblogs::find($id)->first();
        return redirect("blogs/$id")->with("category_name",$category->name);
    }
    public function categoryUpdate(Request $request,$id){
        $category=categoryblogs::find($id)->first();
        $category->name=$request->all()["name"];
        $category->save();
        return redirect("blogs");
    }
    public function listCategory(){
        $category=categoryblogs::select("*")->get();
        return $category;
    }
    public function setParentChild($id){
        $category=categoryBlogs::where("id",$id)->first();
        if(!empty($category)) {
            $category->is_parent = 1;
            $category->save();
        }
    }
    public function deletecategory($id){
        $category=categoryblogs::where("id",$id)->first();
        $category->delete();
        return redirect("blogs");
    }

    public function createBlog(Request $request){
        $input=$request->all();
        $validator=Validator::make($input,[
            "title"=>'required|max:255|string',
            "summery"=>'required|max:512|string',
            "details"=>'required|string',
            "image"=>'required|mimes:jpg,jpeg,png|max:10000'
        ]);
        if($validator->fails()){
            return redirect('blogs')
                ->withErrors($validator,"blogs")
                ->withInput();
        }
        $file = $request->file('image');
        $destination=public_path()."/upload/";
        $filename=$this->uploadfile($destination,$file);
        if($filename!=false){
            $blog=new blogs();
            $blog->title=$request->all()["title"];
            $blog->summery=$request->all()["summery"];
            $blog->details=$request->all()["details"];
            $blog->image=$filename;
            $blog->categoryBlogs=$request->all()["category"];
            $blog->like=0;
            $blog->disLike=0;
            $blog->visited=0;
            $blog->author=1;
            $blog->save();
        }
        return redirect('blogs');
    }
    public function listBlogs(){
    $blogs=blogs::select("*")->get();
    return $blogs;
}
    public function editBlog($id){
        $blog=blogs::find($id)->first();
        return redirect("blogs")->with("blog",$blog);
    }
    public function blogUpdate(Request $request,$id){
        $blog=blogs::find($id)->first();
        $destination=public_path()."/upload/";
        $file=$blog->image;
        if(!empty($request->file("image"))){
            $oldfile=$file;
            $file=$this->uploadfile($destination,$request->file("image"));
            if($file!=false){
                $this->deletefile($destination,$oldfile);
            }
        }
        $blog->title=$request->all()["title"];
        $blog->summery=$request->all()["summery"];
        $blog->details=$request->all()["details"];
        $blog->image=$file;
        $blog->categoryBlogs=$request->all()["category"];
        $blog->save();
        return redirect("blogs");
    }
    public function deleteblog($id){
        $category=blogs::where("id",$id)->first();
        $destination=public_path()."/upload/";
        if(file_exists(public_path()."/upload/".$category->image))
            $this->deletefile($destination,$category->image);
        $category->delete();
        return redirect("blogs");
    }
    public function uploadfile($destination,$file){
        $filename=$file->getClientOriginalName();
        $name=explode('.',$file->getClientOriginalName())[0];
        $extenstion=$file->getClientOriginalExtension();
        while(file_exists($destination.$filename)){
            $filename=$name."_".rand(1,10000000).".".$extenstion;
        }
        if($file->move($destination,$filename)){
            return $filename;
        }
        return false;
    }
    public function deletefile($destination,$filename){
        if(file_exists($destination."/".$filename)){
            unlink($destination."/".$filename);
            return 1;
        }
        return 0;
    }
}
