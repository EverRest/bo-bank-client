<?php
declare(strict_types=1);

namespace App\Http\Requests\Request;

use App\Enums\IndexRequestEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            IndexRequestEnum::searchKey->value => ['string', 'nullable', 'min:3', 'max:50',],
            IndexRequestEnum::sortKey->value => ['string', 'nullable', 'min:3', 'max:50',],
            IndexRequestEnum::limitKey->value => ['numeric', 'nullable', 'min:1', 'max:50',],
            IndexRequestEnum::orderKey->value => [
                'string',
                'nullable',
                'min:1',
                'max:10',
                Rule::in(['asc', 'ASC', 'desc', 'DESC',]),
            ],
            IndexRequestEnum::pageKey->value => ['numeric', 'min:1'],
        ];
    }
}
