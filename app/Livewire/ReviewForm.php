<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Company;
use App\Models\Review;

class ReviewForm extends Component
{
    public Company $company;

    public $name = '';
    public $comment = '';
    public $rating = 5;


    public function mount(Company $model)
    {
        $this->company = $model;
    }


    public function submit()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:100',
            'comment' => 'required|string|min:10|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ], [
            'name.required' => 'نام الزامی است.',
            'name.max' => 'نام نمی‌تواند بیش از 100 کاراکتر باشد.',
            'comment.required' => 'نظر الزامی است.',
            'comment.min' => 'نظر باید حداقل 10 کاراکتر باشد.',
            'comment.max' => 'نظر نمی‌تواند بیش از 1000 کاراکتر باشد.',
            'rating.required' => 'امتیاز الزامی است.',
            'rating.min' => 'امتیاز باید بین 1 تا 5 باشد.',
            'rating.max' => 'امتیاز باید بین 1 تا 5 باشد.',
        ]);

        Review::create([
            'name' => $validated['name'],
            'comment' => $validated['comment'],
            'rating' => $validated['rating'],
            'reviewable_type' => Company::class,
            'reviewable_id' => $this->company->id,
            'is_verified' => false,
        ]);

        $this->reset([
            'name',
            'comment',
            'rating'
        ]);

        session()->flash(
            'success',
            'نظر شما ثبت شد و پس از تایید نمایش داده می‌شود.'
        );
    }


    public function render()
    {
        return view('livewire.review-form');
    }
}
