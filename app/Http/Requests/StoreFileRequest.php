<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    // /**
    //  * Get the validation rules that apply to the request.
    //  *
    //  * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
    //  */
    public function rules(): array
    {
        return [
            // 'file' => 'required|file|mimes:doc,docx,txt,pdf',
            'doc'  => array('application/msword', 'application/vnd.ms-office'),
            'docx' => array('application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip'),
            'pdf' => array('application/pdf'),
        ];
    }
}
