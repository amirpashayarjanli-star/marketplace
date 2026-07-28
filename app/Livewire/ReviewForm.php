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
        Review::create([
            'name' => $this->name,
            'comment' => $this->comment,
            'rating' => $this->rating,
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
