<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use App\Models\Nomination;
use App\Models\NominationPrequalification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /*$this->app->bind('path.public', function() {
            return base_path().'/';
        });*/
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        Validator::extend('yeargtcurrentyear', function ($attribute, $value, $parameters, $validator) {
            $currentyear = (int)date("Y");
            $enteredyear = (int)$value;
            if($enteredyear <= $currentyear) {
                return true;
            }
            return false;
        }, ':attribute cannot be greater than current year.');

        Validator::extend('dategtcurrentdate', function ($attribute, $value, $parameters, $validator) {
            $currentdate = date("d-m-Y");
            $str_time = strtotime($value);
            $entereddate = date("d-m-Y", $str_time);
            $date_diff = date_diff(date_create($currentdate), date_create($entereddate));
            $difference = (int)$date_diff->format('%r%a');

            if($difference >= 1) {
                return false;
            }
            return true;
        }, ':attribute cannot be greater than current date.');

        Validator::extend('isgtminage', function ($attribute, $value, $parameters, $validator) {

            $nomination_id = $validator->getdata()["nomination_id"];
            $nomination = Nomination::find($nomination_id);
            $min_age = $nomination->minimum_age;

            $today = date('d-m-Y');

            $back_date = date("Y-m-d", strtotime("-".$min_age." year", strtotime($today)));
            $back_date_diff = date_diff(date_create($back_date), date_create($today));
            $min_age_in_days = $back_date_diff->format('%a');

            $diff = date_diff(date_create($value), date_create($today));
            $age_in_days = $diff->format('%a');

            if($age_in_days >= $min_age_in_days) {
                return true;
            }

            return false;
        }, 'Your are under age to submit your application form.');

        Validator::extend('isltmaxage', function ($attribute, $value, $parameters, $validator) {

            $nomination_id = $validator->getdata()["nomination_id"];
            $nomination = Nomination::find($nomination_id);
            $max_age = $nomination->maximum_age;

            $today = date('d-m-Y');

            $back_date = date("Y-m-d", strtotime("-".$max_age." year", strtotime($today)));
            $back_date_diff = date_diff(date_create($back_date), date_create($today));
            $max_age_in_days = $back_date_diff->format('%a');

            $diff = date_diff(date_create($value), date_create($today));
            $age_in_days = $diff->format('%a');

            if($age_in_days <= $max_age_in_days) {
                return true;
            }

            return false;
        }, 'Your are over age to submit your application form.');

        Validator::extend('isgtrequiredpercentage', function ($attribute, $value, $parameters, $validator) {

            $nomination_id = $validator->getdata()["nomination_id"];
            $qualification_id = $validator->getdata()["qualification_id"];
            $total_marks = $validator->getdata()["total_marks"];
            $obtained_marks = $validator->getdata()["obtained_marks"];
            $nominationprequalification = NominationPrequalification::where('nomination_id', $nomination_id)->where('qualification_id', $qualification_id)->first();

            $percentage_marks = ((float)$obtained_marks / (float)$total_marks)*100;

            if($percentage_marks >= $nominationprequalification->min_passing_percentage) {
                return true;
            }

            return false;
        }, 'You are in-eligible to apply because your percentage is below the required percentage.');

        /*Validator::replacer('yeargtcurrentyear', function($message, $attribute, $rule, $parameters){
            return str_replace(':attribute', $parameters[0], $message);
        });*/
    }
}
