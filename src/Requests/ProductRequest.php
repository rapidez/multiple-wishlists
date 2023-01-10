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

    public function withValidator($validator)
    {
        if (is_int($this->product_id)) {
            $product = Product::selectAttributes(['id'])->findOrFail($this->product_id);
        } else {
            $builder = Product::selectAttributes(['id']);
            $product = $builder->where($builder->getQuery()->from.'.sku', $this->product_id)->firstOrFail();
            $this->request->add(['product_id' => $product->id]);
            $this->product_id = $product->id;
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
