<?php

namespace App\Http\Controllers;

use App\Models\ToolsDatatableModel;

class IndexController extends Controller
{
	public function __construct()
	{
	    $this->middleware('auth');
	}
	
	public function index()
	{
		$menu_arr = ToolsDatatableModel::get()->toArray();
		$tree = new \App\Http\Controllers\Common\TreeController($menu_arr);
		$menu_arr = $tree->listToTree();
		return view('index', [
			'menu_arr' => $menu_arr,
		]);
	}
}