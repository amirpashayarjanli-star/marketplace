<div>

    @if(session()->has('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif


    <form wire:submit="submit">

        <div>
            <label>نام</label>

            <input
                type="text"
                wire:model="name"
            >
        </div>


        <div>
            <label>امتیاز</label>

            <select wire:model="rating">

                <option value="5">★★★★★</option>
                <option value="4">★★★★</option>
                <option value="3">★★★</option>
                <option value="2">★★</option>
                <option value="1">★</option>

            </select>
        </div>


        <div>
            <label>نظر شما</label>

            <textarea wire:model="comment"></textarea>

        </div>


        <button type="submit">
            ارسال نظر
        </button>


    </form>

</div>
