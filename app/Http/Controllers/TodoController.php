<?php
//アプリケーションの機能の要を担っているメソッドを定義しているファイル。
//
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;  // 追記
use Auth;  // 追記

class TodoController extends Controller
{
    private $todo;

    public function __construct(Todo $instanceClass)
    {
        $this->middleware('auth');  // 追記
        $this->todo = $instanceClass;
        //dd($this->middleware('auth'));
        // dd($this->todo);
    }
    // ここまで追記
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = $this->todo->getByUserId(Auth::id());
        // dd($todos);
        return view('todo.index', compact('todos'));  // 編集
    }
    //viewメソッドの第一引数は正確にはviewsフォルダからの、表示したいファイル位置を示している

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('todo.create');  // 追記
    }
    //⬆︎View fileの指定を行います。
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();
        // dd($input);
        // dd($this->todo->fill($input));
        $input['user_id'] = Auth::id();  // 追記
        $this->todo->fill($input)->save();
        // dd($this->todo->fill($input)->save());
        return redirect()->route('todo.index');
    }
    //引数のRequest $requestはRequestクラスのインスタンスを$requestに代入している。フォームで渡された値。
    //
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo = $this->todo->find($id);  // 追記
        // dd($todo);
        return view('todo.edit', compact('todo'));  // 追記        

    }
    //findメソッドはidを指定してDBから取得できる。
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request, $id);
        //
        $input = $request->all();
        // dd($this->todo->find($id));
        $this->todo->find($id)->fill($input)->save();
        // dd();
        return redirect()->route('todo.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $this->todo->find($id)->delete();
        // dd(redirect()->to('todo'));
        return redirect()->route('todo.index');
    }

}
