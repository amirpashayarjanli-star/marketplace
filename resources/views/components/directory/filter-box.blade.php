<div class="directory-filter glass-card">


    {{-- Search --}}

    <div class="directory-search">


        <i class="fa-solid fa-magnifying-glass"></i>


        <input
            type="text"
            placeholder="جستجوی شرکت آسانسوری...">


    </div>




    {{-- Filters --}}

    <div class="directory-options">


        <select>

            <option>
                انتخاب شهر
            </option>


            <option>
                تهران
            </option>


            <option>
                قم
            </option>


            <option>
                اصفهان
            </option>


        </select>




        <select>


            <option>
                مرتب سازی
            </option>


            <option>
                بیشترین امتیاز
            </option>


            <option>
                بیشترین نظر
            </option>


            <option>
                جدیدترین
            </option>


        </select>



    </div>




    {{-- Register Company --}}

    <a href="#"
       class="register-company-btn">


        <i class="fa-solid fa-building"></i>


       {{ $register ?? 'ثبت' }}


    </a>



</div>
