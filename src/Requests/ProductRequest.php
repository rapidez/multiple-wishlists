<?php

namespace Rapidez\MultipleWishlist\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Rapidez\Core\Models\Product;

class ProductRequest extends FormRequest
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
        if (is_int($this->product_id)) {
            $product = Product::withoutGlobalScopes()->findOrFail($this->product_id);
        } else {
            $builder = Product::withoutGlobalScopes();
            $product = $builder->where($builder->getQuery()->from.'.sku', $this->product_id)->firstOrFail();
            $this->merge(['product_id' => $product->entity_id]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [];
    }
}
