<?php

namespace App\Http\Requests\posts;

use App\Enums\Status;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'platform_id' => 'required|array',
            'platform_id.*' => 'exists:platforms,id',
            'title' => 'required|string|max:255|unique:posts,title',
            'content' => 'required|string',
            'scheduled_time' => 'required|date|after_or_equal:now',
            'status' => ['required', 'string', Rule::enum(Status::class)],
            'scheduled_at' => 'nullable|date|after_or_equal:now',
            'published_at' => 'nullable|date|after_or_equal:scheduled_at',
        ];
    }

    /**
     * Prepare the data for validation.
     */

    protected function prepareForValidation(): void
    {

        if($this->status  == Status::SCHEDULED->value) {

             $this->merge(['scheduled_at' => Carbon::now()->toDateTimeString()]);

        } elseif ($this->status == Status::PUBLISHED->value) {

             $this->merge(['published_at' => Carbon::now()->toDateTimeString()]);
        }
    }
}
