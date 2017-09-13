<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Input;
use Lang;
use Redirect;

use App\User;

class UserController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function __construct(){
		$this->middleware('auth');
	}

	protected $redirectTo = 'users';

	public function index(Request $request) {
		$filters = new \stdClass();
        $filters->search = $request->input('search');
        $filters->limit  = $request->input('limit');

        if(!$filters->limit) $filters->limit = 25;

        if($filters->search)
            $query = User::where('name', 'REGEXP', $filters->search)
        				->orWhere('username', 'REGEXP', $filters->search)
        				->orderBy('name');
        else
            $query = User::orderBy('name');
        
        $items = $query->paginate($filters->limit);

		return view('users/index', ['items' => $items, 'filters' => $filters]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('users/edit', ['item' => new User()]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		$hashedPassword = bcrypt($request->input('password'));
		$confirmPassword = $request->input('confirm_password');
		if (Hash::check($confirmPassword, $hashedPassword)) {
			$this->validateForm($request);
			$item = new User();
			$this->setAttributes($item, $request);
			$item->password = $hashedPassword;

			$status     = $item->save();
        	$messages   = $status? Lang::get('app.save_success') : Lang::get('app.save_failed');
        	
			return redirect('users')->with('status', $status)->with('messages', $messages);
		}
		
		return Redirect::back()->withInput()->withErrors([Lang::get('app.pass_not_match')]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$item = User::find($id);
		return view('users/edit', ['item' => $item]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$this->validateForm($request);
		$item = User::find($request->input('id'));
        $this->setAttributes($item, $request);
        
        $status     = $item->save();
        $messages   = $status? Lang::get('app.save_success') : Lang::get('app.save_failed');

		return redirect('users')->with('status', $status)->with('messages', $messages);    
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(User $user) {
		$status = $user->delete();
        $data   = User::orderBy('name')->get();

        $messages = $status? Lang::get('app.delete_success') : Lang::get('app.delete_failed');
        
        return redirect()->route('users.index')->with('status', $status)->with('messages', $messages);
	}

	public function viewChangePass($id) {
		$item = User::find($id);
		return view('users/changepass', ['item' => $item]);
	}

	public function doChangePass(Request $request) {
		$oldPass = $request->input('old_password');
		$newPass = $request->input('new_password');
		$confirmPass = $request->input('confirm_password');
		$user = User::find($request->input('id'));

		if (Hash::check($oldPass, $user->password)) {
			if ($newPass == $confirmPass) {
				$user->password = bcrypt($newPass);
				$status = $user->save();
				$messages   = $status? Lang::get('app.save_success') : Lang::get('app.save_failed');
				return redirect('users')->with('status', $status)->with('messages', $messages);
			}
		}

		return Redirect::back()->withErrors([Lang::get('app.pass_not_match')]);
	}

	public function viewResetPass($id) {
		$item = User::find($id);
		return view('users/resetpass', ['item' => $item]);
	}

	public function doResetPass(Request $request) {
		$newPass = $request->input('new_password');
		$confirmPass = $request->input('confirm_password');
		$user = User::find($request->input('id'));

		if ($newPass == $confirmPass) {
			$user->password = bcrypt($newPass);
			$status = $user->save();
			$messages   = $status? Lang::get('app.save_success') : Lang::get('app.save_failed');
			return redirect('users')->with('status', $status)->with('messages', $messages);
		}

		return Redirect::back()->withErrors([Lang::get('app.pass_not_match')]);
		// dd($oldPass, $newPass, $confirmPass);
	}

	private function setAttributes($item, Request $request){
		$item->name         = $request->input('name');
		$item->username     = $request->input('username');
		$item->email 		= $request->input('email');
	}

	private function validateForm(Request $request){
		$this->validate($request, [
			'name'  	=> 'required',
			'username'  => 'required',
			'email'  	=> 'required'
		]);
	}
}

