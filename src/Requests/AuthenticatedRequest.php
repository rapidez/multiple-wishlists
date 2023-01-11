<?php

namespace Rapidez\MultipleWishlist\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class AuthenticatedRequest extends FormRequest
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

    public function prepareForValidation()
    {
        $token = $this->bearerToken();
        abort_if(!$token, 403);

        $authId = DB::table('oauth_token')
                ->where('token', $token)
                ->where('revoked', 0)
                ->value('customer_id');

        abort_if(!$authId, 403);

        // Add customer ID to the request
        $this->merge(['customer_id' => $authId]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'customer_id' => 'required|integer'
        ];
    }
}
