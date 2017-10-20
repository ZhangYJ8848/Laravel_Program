<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Post;
use App\User;
//use Input, Auth;
use Illuminate\Http\Request;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/posts/example',array('as'=>'admin.home',function (){
    $url = route('admin.home');
    return"this url is ".$url;
}));

//Route::get('/post/{ind}','PostsController@index');

//Route::resource( 'posts' , 'PostsController' );
Route::get('/contact','PostsController@contact');
Route::get('/posts/{id}/{name}/{passwd}','PostsController@show_post');

use Illuminate\Support\Facades\DB;
Route::get('/insert',function (){
    DB::insert('insert into posts(title,content) VALUES (?,?)',['Laravel','PHP is also the best PHP framework 2']);
});

Route::get('/readdata',function (){
    $result=DB::select('select * from posts ');
    $returndata = '';
    foreach($result as $item) {
        $returndata =  $returndata.'<p>'. $item->content.'</p>';

   }
   return $returndata;
});

Route::get('/read',function (){
    $result = \App\Post::where('id',2)->orderBy('id','desc')->take(1)->get();
    foreach ($result as $item)
    return $item->title;
});

Route::get('/inserting',function(){
   $post = new  Post;
   $post->title='New ORM Title';
   $post->content='Wow ORM is really cool!';
   $post->save();
});

Route::get('/create',function (){

   Post::create(['title'=>'the create','content'=>'WOW']) ;
});

Route::get('/update',function (){
    Post::where('id',2)->update([
        'title'=>'NEW PHP TITLE','content'=>'I love you']);
});

Route::get('/delete',function(){
   $post = Post::find(1);
   $post=$post->delete();
});

Route::get('/delete2',function (){
    Post::destroy([2,4]);
});

Route::get('/softdelete',function(){
    Post::find(5)->delete();
});

Route::get('/readsoftdelete/{id}',function ($id){
//    $post=Post::find($id);
//    return $post;
    $post=Post::withTrashed()->where('id',$id)->get();
    return $post;

});

Route::get('/restore',function(){
   $post = Post::withTrashed()->find(5);
   $post->restore();
   return  'nice';
});

Route::get('/forcedelete',function(){
    $post = Post::withTrashed()->find(5);
    $post->forcedelete();
    return  'nice';
});

Route::get('/{id}/post',function($id){
    return  User::find($id)->post();
});

Route::get('/posts',function(){
    $user = User::find(1);
    foreach ($user->posts as $post){
        echo "<p>".$post -> content . "</p>";
    }
});

Route::get('/users/{id}/role',function ($id){
    $user = User:: find($id)->roles;
    foreach ($user as $item) {
        echo '<p>', $item -> name,'</p>';
    }

});

Route::get('/pc_application/get/{id}',function ($id){
    return 'Welcome, PC application No.'.$id.'!';
});

//Route::post('/pc_application/post',function(Request $request){
//    $name = $request->input('name');
//    return 'Welcome, PC application No.'.', and name:'.$name.'!';
//});
Route::post('/pc_application/post/{id}','PostsController@pc_post');

Route::get('/pc_application/post_form',function(){
//    $csrf_token = csrf_token();
//    $form = <<<FORM
//        <form action="/pc_application/post" method="POST">
//            <input type="hidden" name="_token" value="{$csrf_token}">
//            <input type="text" name="name">
//            <input type="submit" name="name" />
//        </form>
//FORM;
//    return $form;
    return view('pc_post');
});


Route::get('/pc_application/post_form/_token',function(){
    $csrf_token = csrf_token();
    return $csrf_token;
});