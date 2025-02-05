<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Setting extends Model
{
    use HasFactory;

    protected $fillable = array('board_full_name', 'minister_name', 'minister_image', 'ministers_message', 'secretary_name', 'secretary_image', 'secretarys_image', 'controller_name', 'controller_image', 'controllers_message', 'controller_signature', 'deputy_controller_name', 'deputy_controller_signature');

	public static $rules = array(
		'board_full_name'=>'required|min:3',
        'minister_name'=>'required|min:3',
        'minister_image'=>'mimes:jpeg,jpg,png,gif|max:10000',
        'ministers_message'=>'required|min:40',
        'secretary_name'=>'required|min:3',
        'secretary_image'=>'mimes:jpeg,jpg,png,gif|max:10000',
        'secretarys_message'=>'required|min:40',
        'controller_name'=>'required|min:3',
        'controller_image'=>'mimes:jpeg,jpg,png,gif|max:10000',
        'controllers_message'=>'required|min:40',
        'controller_signature'=>'mimes:jpeg,jpg,png,gif|max:10000',
        'deputy_controller_name'=>'required|min:3',
        'deputy_controller_signature'=>'mimes:jpeg,jpg,png,gif|max:10000'
	);
}
