<section class="top-companies-section technicians-section">

    <div class="container">


        <div class="section-header">

            <h2>
                تکنسین‌های برتر آسانسور
            </h2>


            <a href="#">
                مشاهده همه
                <i class="fa-solid fa-arrow-left"></i>
            </a>

        </div>



        <div class="companies-grid">


            @forelse($topTechnicians as $technician)

                @include('components.card-technician', [
                    'technician' => $technician
                ])

            @empty

                <p>
                    هنوز تکنسینی ثبت نشده است.
                </p>

            @endforelse


        </div>


    </div>

</section>
