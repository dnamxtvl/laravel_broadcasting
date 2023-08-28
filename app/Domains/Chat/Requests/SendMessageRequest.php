<?php

namespace App\Domains\Chat\Requests;

use App\Domains\Chat\Enums\ExceptionCode;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Lucid\Bus\UnitDispatcher;
use Lucid\Domains\Http\Jobs\RespondWithJsonErrorJob;
use Symfony\Component\HttpFoundation\Response;

class SendMessageRequest extends FormRequest
{
    use UnitDispatcher;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'to_user_id' => 'integer',
            'message' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'to_user_id.integer' => 'UserId phải là số!',
            'message.required' => 'Message đang để trống'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $message = (new ValidationException($validator))->errors();

        return $this->run(new RespondWithJsonErrorJob(
            message: $message,
            code: ExceptionCode::SEND_MESSAGE_VALIDATION_ERROR->value,
            status: Response::HTTP_UNPROCESSABLE_ENTITY
        ));
    }
}
