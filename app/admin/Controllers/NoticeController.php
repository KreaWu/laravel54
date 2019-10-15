<?php
namespace App\admin\Controllers;

use \App\Notice;

class NoticeController extends Controller
{
    public function index(){
        $notices = \App\Notice::all();
        return view('/admin/notice/index', compact('notices'));
    }

    public function create(){
        return view('/admin/notice/create');

    }

    public function store(){
        $this->validate(request(), [
            'title'=>'required|min:2|string',
            'content'=>'required|string',
        ]);

        $notice = \App\Notice::create(request(['title', 'content']));

        //创建发送逻辑dispatch（队列发送消息，发送job）
        $this->dispatch(new \App\Jobs\SendMessage($notice));


        return redirect('/admin/notices');

    }
}