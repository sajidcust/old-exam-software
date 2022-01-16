<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class District extends Model
{
    use HasFactory;

    protected $fillable = array('name');

	public static $rules = array(
		'name'=>'required|min:3'
	);

	public function getTotalStudents($district_id){
		$count = Student::join('institutions', 'institutions.id', '=', 'students.center_id')->join('tehsils', 'tehsils.id', '=', 'institutions.tehsil_id')->join('districts', 'districts.id', '=', 'tehsils.district_id')->where('districts.id', $district_id)->count();
		return $count;
	}
}
