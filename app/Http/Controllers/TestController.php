<?php 

namespace App\Http\Controllers;

use App\Http\Requests\SampleRequest;

class TestController extends Controller
{

    /**
     * テストページ表示
     */
    public function index()
    {
        return view('test');
    }
    
    /**
     * テストページ表示
     */
    public function test(SampleRequest $request)
    {
        return view('test2');
    }
    
    /**
     * テストページ表示
     */
    public function test2(SampleRequest $request)
    {
        return view('test2');
    }
}