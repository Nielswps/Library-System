<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreItem extends FormRequest
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
        if($this->input('itemType') == 'movie'){
            return [
                'movieTitle' => 'required_without:fileUpload',
                'releaseYear' => 'required_without:fileUpload'
            ];
        } else if($this->input('itemType') == 'book'){
            return [
                'bookTitle' => 'required_without:fileUpload',
                'writer' => 'required_without:fileUpload'
            ];
        } else{
            return [];
        }
    }
    public function messages()
    {
        return [
            'movieTitle.required_without:fileUpload' => 'A title for the movie is required',
            'releaseYear.required_without:fileUpload'  => 'A release year for the movie is required',
            'bookTitle.required_without:fileUpload' => 'A title for the book is required',
            'writer.required_without:fileUpload' => 'A writer of the book is required',
        ];
    }
}
