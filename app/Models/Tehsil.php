<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class Tehsil extends Model
{
    use HasFactory;

    protected $fillable = array('name', 'district_id');

	public static $rules = array(
		'name'=>'required|min:3',
		'district_id'=>'required|integer'
	);

	public function students() {
		return $this->hasMany(Student::class, 'tehsil_id');
	}
}
