<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddSalaryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // if($this->deduction_name) {
        //     $a = count($this->deduction_name);
        //     $b = count($this->deduction_amount);
        //     $c = count($this->deduction_description);
        //     $d = count($this->deduction_date);
        //     if(($a != $b) || ($b != $c) || ($c != $d)) {
        //         return ['success' => 'danger', 'message' => 'Something went wrong with leaves inputs.']; // redirect()->back()->with(['success' => 'danger', 'message' => 'Something went wrong with deduction inputs.'])->withInput();
        //     }
        //     unset($a, $b, $c, $d);
        //     $a = count($this->leave_type);
        //     $b = count($this->cl_leave_type);
        //     $c = count($this->leave_date);
        //     $d = count($this->leave_description);
        //     if(($a != $b) || ($b != $c) || ($c != $d)) {
        //         return ['success' => 'danger', 'message' => 'Something went wrong with leaves inputs.']; // redirect()->back()->with(['success' => 'danger', 'message' => 'Something went wrong with leaves inputs.'])->withInput();
        //     }
        //     unset($a, $b, $c, $d);
        // }

        // dd($this->cl_leave_type);
        return [
            'employee' => 'required|exists:users,id',
            'working_days' => 'required|numeric',
            'no_of_days_worked' => 'required|numeric',
            'sd_pf' => 'sometimes',
            'sd_i' => 'sometimes',
            'sd_pt' => 'sometimes',
            'deduction_name' => 'sometimes|array',
            'deduction_name.*' => 'required_with:deduction_date.*|nullable',
            'deduction_date' => 'sometimes|array',
            'deduction_date.*' => 'required_with:deduction_name.*|date',
            'deduction_amount' => 'sometimes|array',
            'deduction_amount.*' => 'required_with:deduction_name.*|numeric',
            'deduction_description' => 'sometimes|array',
            'deduction_description.*' => 'nullable|string',
            'leave_type' => 'sometimes|array',
            'leave_type.*' => 'required_with:cl_leave_type.*|exists:leave_types,id',
            'cl_leave_type' => 'sometimes|array',
            'cl_leave_type.*' => 'required_with:leave_type.*|exists:cl_type,id',
            'leave_date' => 'sometimes|array',
            'leave_date.*' => 'required_with:leave_type.*|date',
            'leave_description' => 'sometimes|array',
            'leave_description.*' => 'nullable|string',
            'incentive_date' => 'sometimes|array',
            'incentive_date.*' => 'required_with:incentive_amount.*|date',
            'incentive_amount' => 'sometimes|array',
            'incentive_amount.*' => 'required_with:incentive_date.*|numeric',
            'incentive_description' => 'sometimes|array',
            'incentive_description.*' => 'nullable|string'
        ];
    }

    public function messages() {
        return [
            'deduction_name.*.string' => 'Deduction name must be a string.',
            'deduction_name.*.min' => 'Deduction name must be of minimum length 3.',
            'deduction_name.*.max' => 'Deduction name must be of maximum length 20.',
            'deduction_date.*.date' => 'Deduction date must be in valid format.',
            'deduction_amount.*.numeric' => 'Deduction amount must be numeric.',
            'deduction_description.*.string' => 'Description must be a string.',
            'deduction_description.*.min' => 'Description must be minimum 5.',
            'deduction_description.*.max' => 'Description must be maximum 150.',
            'leave_type.*.exists' => 'The selected leave type is invalid.',
            'cl_leave_type.*.exists' => 'The selected CL type is invalid.',
            'leave_date.*.date' => 'The leave date is invalid.',
            'leave_description.*.string' => 'Leave description must be a string.',
            'incentive_date.*.date' => 'INcentive date is invalid.',
            'incentive_amount.*.numeric' => 'Incentive amount is numeric.',
            'incentive_description.*.string' => 'Incentive description must be a string.',
            'deduction_name.*.required_with' => 'Deduction name is required.',
            'deduction_date.*.required_with' => 'Deduction date is required.',
            'deduction_amount.*.required_with' => 'Deduction amount is required.',
            'leave_type.*.required_with' => 'Leave type is required.',
            'cl_leave_type.*.required_with' => 'CL type is required.',
            'leave_date.*.required_with' => 'Leave date is required.',
            'incentive_date.*.required_with' => 'Incentive date is required.',
            'incentive_amount.*.required_with' => 'Incentive amount is required.'
        ];
    }
}
