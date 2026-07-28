<?php

namespace App\Livewire;

use Livewire\Component;

class ReviewForm extends Component
{
    public $model;

    public $name;
    public $comment;
    public $rating = 5;


    public function submit()
    {
        $this->validate([
            'name' => 'required|min:2',
            'comment' => 'required|min:5',
            'rating' => 'required|integer|min:1|max:5',
        ]);


        $this->model->reviews()->create([
            'name' => $this->name,
            'comment' => $this->comment,
            'rating' => $this->rating,
            'is_verified' => false,
        ]);


        $this->reset([
            'name',
            'comment',
            'rating',
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
