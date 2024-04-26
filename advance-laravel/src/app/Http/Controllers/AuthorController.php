<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

use App\Http\Requests\AuthorRequest;

class AuthorController extends Controller
{
    //  データ追加用ページの表示
    public function add()
    {
        return view('add');
    }
    //追加機能
    public function create(AuthorRequest $request)
    {
        $form = $request->all();
        Author::create($form);
        return redirect('/');
    }
    //データ一覧ページの表示
    public function index()
    {
        $authors = Author::simplePaginate(4);
        return view('index', ['authors' => $authors]);
    }
    public function find()
    {
        return view('find', ['input' => '']);
    }
    public function search(Request $request)
    {
        $item = Author::where('name', $request->input)->first();
        $param = [
            'input' => $request->input,
            'item' => $item
        ];
        return view('find', $param);
    }
    public function bind(Author $author)
    {
        $data = [
            'item' => $author,
        ];
        return view('author.binds', $data);
    }
    //データ編集ページの表示
    public function edit(Request $request)
    {
        $author = Author::find($request->id);
        return view('edit', ['form' => $author]);
    }

    //更新機能
    public function update(AuthorRequest $request)
    {
        $form = $request->all(); //データ取得
        unset($form['_token']); //トークン削除
        Author::find($request->id)->update($form); //findメソッドの引数にリクエストで取得したidを指定。そのレコードをupdateメソッドで$formの内容をもとに更新
        return redirect('/');
    }
    //データ削除用ページの表示
    public function delete(Request $request)
    {
        $author = Author::find($request->id);
        return view('delete', ['author' => $author]);
    }

    //削除機能
    public function remove(Request $request)
    {
        Author::find($request->id)->delete();
        return redirect('/');
    }

    public function verror()
    {
        return view('verror');
    }
    //authorテーブルのデータを返すrelate
    public function relate(Request $request)  //追記
    {
        $hasItems = Author::has('book')->get();
        $noItems = Author::doesntHave('book')->get();
        $param = ['hasItems' => $hasItems, 'noItems' => $noItems];
        return view('author.index', $param);
    }
}
