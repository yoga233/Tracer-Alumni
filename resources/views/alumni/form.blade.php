<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formulir Alumni - Tracer Study ITATS</title>
    @vite('resources/css/app.css')
    <style>
        .progress-bar-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.875rem;
        color: #666;
        }
        .progress-bar {
        height: 4px;
        flex: 1;
        background-color: #e5e7eb;
        margin: 0 0.5rem;
        border-radius: 9999px;
        overflow: hidden;
        }
        .progress-bar-fill {
        background-color: #3b82f6;
        height: 100%;
        width: 0%;
        transition: width 0.3s ease;
        }
    </style>
    </head>
    <body class="bg-[#F2EBDC] min-h-screen flex items-center justify-center">

        <div class="bg-gray-100 w-full max-w-[40rem] mx-auto bg-transparent">

        @include('alumni.partials.nav-form')
        <img src="{{ asset('images/image.png') }}" alt="Ilustrasi Tracer Study" class="py-4 relative rounded">
        @include('alumni.partials.box-sambutan')
        
            <form id="multiStepForm" action="{{ route('alumni.form.submit') }}" method="POST" class="space-y-6">
            
            @csrf
            <!-- Halaman-halaman -->
            <div class="step" id="step1">
                @include('alumni.partials.form-informasi-alumni')
            </div>

            <div class="step hidden" id="step2">
                @include('alumni.partials.dinamis-pertanyaan')
                @include('alumni.partials.kompetensi_saat_lulus')
            </div>

            <!-- Bisa ditambah halaman di sini -->
            <!-- <div class="step hidden" id="step3">...</div> -->
            <div class="step hidden" id="step3">
                @include('alumni.partials.pekerjaan')
            </div>


            <!-- Progress dan tombol -->
            <div class="flex items-center justify-between mt-4">
                <div class="flex items-center gap-2 text-sm">
                <button type="button" id="resetBtn" class="text-yellow-600 hover:underline">Kosongkan formulir</button>
                </div>
                <div class="flex-1 flex items-center justify-center">
                <div class="progress-bar-container">
                    <span>Halaman <span id="currentPage">1</span> dari <span id="totalPages">1</span></span>
                    <div class="progress-bar">
                    <div id="progressFill" class="progress-bar-fill"></div>
                    </div>
                </div>
                </div>
                <div class="flex gap-2">
                <button type="button" id="prevBtn" class="bg-white border border-gray-300 px-4 py-2 rounded text-sm hidden">Sebelumnya</button>
                <button type="button" id="nextBtn" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded text-sm">Berikutnya</button>
                <button type="submit"  id="submitBtn" class="submitBtn hidden bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-md shadow-md transition">
        Kirim Formulir
    </button>

                </div>
            </div>
            </form>

        
    </div>

    <script>
        const steps = document.querySelectorAll('.step');
        const totalSteps = steps.length;
        let currentStep = 1;

        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const submitBtn = document.getElementById('submitBtn');
        const progressFill = document.getElementById('progressFill');
        const currentPage = document.getElementById('currentPage');
        const totalPages = document.getElementById('totalPages');
        const resetBtn = document.getElementById('resetBtn');
        const form = document.getElementById('multiStepForm');

        totalPages.textContent = totalSteps;

        function showStep(step) {
        steps.forEach((s, i) => {
            if (i === step - 1) {
            s.classList.remove('hidden');
            } else {
            s.classList.add('hidden');
            }
        });

        currentPage.textContent = step;
        const progress = (step / totalSteps) * 100;
        progressFill.style.width = progress + '%';

        if (step === 1) {
            prevBtn.classList.add('hidden');
            nextBtn.classList.remove('hidden');
            submitBtn.classList.add('hidden');
        } else if (step === totalSteps) {
            prevBtn.classList.remove('hidden');
            nextBtn.classList.add('hidden');
            submitBtn.classList.remove('hidden');
        } else {
            prevBtn.classList.remove('hidden');
            nextBtn.classList.remove('hidden');
            submitBtn.classList.add('hidden');
        }
        }

        nextBtn.addEventListener('click', () => {
        if (currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
        }
        });

        prevBtn.addEventListener('click', () => {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
        });

        resetBtn.addEventListener('click', () => {
        form.reset();
        currentStep = 1;
        showStep(currentStep);
        });

        // Inisialisasi
        showStep(currentStep);
    </script>

</body>
</html>