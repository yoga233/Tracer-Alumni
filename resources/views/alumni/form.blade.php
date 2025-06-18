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
            <div class="flex items-center justify-between mt-8">
                <div class="flex items-center gap-4 text-sm">
                    <button type="button" id="resetBtn" class="text-gray-500 hover:text-red-600 font-normal transition duration-300 ease-in-out focus:outline-none">
                    Reset Formulir
                    </button>
                </div>

                <div class="flex-1 flex items-center justify-center gap-4">
                    <span class="text-gray-600 text-sm">Halaman <span id="currentPage" class="font-semibold text-blue-600">1</span> dari <span id="totalPages">1</span></span>
                    <div class="w-56 bg-gray-200 rounded-full h-1.5 overflow-hidden">
                    <div id="progressFill" class="bg-blue-500 h-full rounded-full transition-all duration-500 ease-out" style="width: 10%;"></div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="button" id="prevBtn" class="hidden bg-transparent border border-gray-300 text-gray-700 hover:bg-gray-100 hover:text-gray-800 font-medium px-5 py-2 rounded-lg transition duration-300 ease-in-out focus:outline-none">
                    Sebelumnya
                    </button>
                    <button type="button" id="nextBtn" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-lg transition duration-300 ease-in-out focus:outline-none">
                    Berikutnya
                    </button>
                    <button type="submit" id="submitBtn" class="hidden bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-2 rounded-lg transition duration-300 ease-in-out focus:outline-none">
                    Kirim Formulir
                    </button>
                </div>
                </div>
            </form>

        
    </div>

    <script>
        // Script untuk navigasi - letakkan di test2.txt
    document.addEventListener('DOMContentLoaded', function() {
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

            // Update tombol visibility
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

        // Delay untuk memastikan script validasi sudah selesai
        setTimeout(() => {
            if (nextBtn) {
                nextBtn.addEventListener('click', function(e) {
                    // Jangan preventDefault di sini, biarkan script validasi yang handle
                    
                    // Tunggu sebentar untuk memastikan validasi selesai
                    setTimeout(() => {
                        // Cek apakah ada error validasi
                        const hasErrors = document.querySelector('.validation-error');
                        
                        if (!hasErrors && currentStep < totalSteps) {
                            currentStep++;
                            showStep(currentStep);
                        }
                    }, 50);
                });
            }
        }, 100);

        if (prevBtn) {
            prevBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });
        }

        if (resetBtn) {
            resetBtn.addEventListener('click', function(e) {
                e.preventDefault();
                form.reset();
                currentStep = 1;
                showStep(currentStep);
                
                // Hapus semua error messages
                document.querySelectorAll('.validation-error').forEach(e => e.remove());
                
                // Reset conditional input
                const inputLainnya = document.getElementById('input_lainnya_container');
                if (inputLainnya) {
                    inputLainnya.classList.add('hidden');
                }
            });
        }

        // Inisialisasi
        showStep(currentStep);
    });
    </script>

</body>
</html>