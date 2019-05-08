<h1>Blogs</h1>
<hr>
<h3>categoryBlog</h3>
<form action="@if(session("category_name")){{url("categoryUpdate")}}/{{$id}}@else {{url("createCategory")}}/{{$id}}@endif" method="post">
    {{csrf_field()}}
    <input type="text" name="name" value="@if(session("category_name")){{session("category_name")}}@endif" placeholder="Enter Category Name"/>
    @if(isset($errors))
        @foreach($errors->category->all() as $message)
            {{$message}}
        @endforeach
    @endif
    <input type="submit" name="send" value="send">
</form>
<hr>

<ul>

    <?php

        function lc($cat){
            $category=\Hosein\Blogs\categoryblogs::select("*")->where("parent",$cat)->get();
            foreach ($category as $value){
                echo "<li><a href='".url("blogs/$value->parent/$value->id")."'>
                $value->name</a>------
                <a href='".url("blogs/$value->id")."'>create_child</a>-------
                <a href='".url("deletecategory/$value->id")."'>delete</a>";
                if($value->is_parent==1){
                    echo "<ul>";
                    lc($value->id);
                    echo "</ul>";
                }
                echo "</li>";
            }
        }
       lc(0);
    ?>




</ul>
<hr>
<h3>Blog</h3>
<form action="@if(session("blog")){{url("blogUpdate")}}/{{session("blog")->id}}@else {{url("createBlog")}}@endif" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    @if(isset($errors))
        @foreach($errors->blogs->all() as $message)
            {{$message}}
        @endforeach
    @endif

    <input type="text" name="title" value="@if(session("blog")){{session("blog")->title}}@endif" placeholder="Enter title"/>
    <textarea name="summery" id="" cols="30"
              rows="10">@if(session("blog")){{session("blog")->summery}}@endif</textarea>
    <textarea name="details" id="" cols="30"
              rows="15">@if(session("blog")){{session("blog")->details}}@endif</textarea>
    <select name="category" id="">
        <?php
        function categoryIsNotParent(){
            $category=\Hosein\Blogs\categoryblogs::select("*")->where("is_parent",0)->get();
            $selected="";

            foreach ($category as $value){
                if(session("blog")){
                    $selected=(session("blog")->categoryBlogs==$value->id)?"selected":"";
                }
                echo "<option value='$value->id' $selected>$value->name</option>";
            }
        }
        categoryIsNotParent();
        ?>
    </select>
    <input type="file" name="image">
    @if(session("blog"))
    <img src="{{asset("/upload/")}}/{{session("blog")->image}}" style="width:50px;height: 50px;" />
    @endif
    <input type="submit" name="send" value="send">
</form>
<hr>
<table border="1">
    <tr>
        <th>id</th>
        <th>image</th>
        <th>title</th>
        <th>create_time</th>
        <th>update_time</th>
        <th>edit</th>
        <th>del</th>
    </tr>
    @if(isset($listBlog))
        @foreach($listBlog as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td><img src="{{asset("/upload/")}}/{{$item->image}}" style="width:50px;height: 50px;" /></td>
                <td>{{$item->title}}</td>
                <td>{{$item->created_at}}</td>
                <td>{{$item->updated_at}}</td>
                <td><a href="{{url("editBlog")}}/{{$item->id}}">edit</a></td>
                <td><a href="{{url("deleteblog")}}/{{$item->id}}">del</a></td>
            </tr>
        @endforeach
    @endif

</table>