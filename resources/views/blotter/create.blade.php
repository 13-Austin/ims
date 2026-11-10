<x-app-layout>
    <x-slot name="header">
        <div class="no-print flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('New Blotter Entry - Katarungang Pambarangay') }}
            </h2>
        </div>
    </x-slot>

    <!-- PRINT STYLES -->
    <style>
        @media print {
            aside, nav, header, .no-print, .space-y-2 {
                display: none !important;
            }
            body, main {
                background-color: white !important;
                padding: 0 !important;
                margin: 0 !important;
                font-size: 10px !important;
                color: #000 !important;
            }
            .max-w-4xl {
                max-width: 100% !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .bg-white {
                background-color: transparent !important;
                padding: 0 !important;
            }
            .py-6, .py-12 { padding: 0 !important; }
            .p-8 { padding: 0.2rem !important; }
            .mb-4, .mb-3, .mb-2 { margin-bottom: 0.2rem !important; }
            
            canvas {
                height: 45px !important;
            }
            input, select, textarea {
                padding: 2px 4px !important;
                font-size: 10px !important;
                border-color: #666 !important;
                background-color: white !important;
            }
        }
    </style>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                <!-- OFFICIAL BARANGAY HEADER -->
                <div class="text-center mb-3 border-b pb-2">
                    <p class="text-[10px] tracking-widest text-gray-600 uppercase">Republic of the Philippines</p>
                    <p class="text-[10px] tracking-widest text-gray-600 uppercase">Province of Zambales</p>
                    <p class="text-[10px] tracking-widest text-gray-600 uppercase">Municipality of Castillejos</p>
                    <p class="text-xs tracking-bold text-gray-800 font-bold uppercase">BARANGAY MAGSAYSAY</p>
                    <h1 class="text-xs font-extrabold text-blue-900 tracking-wider mt-0.5">OFFICE OF THE SANGGUNIANG BARANGAY</h1>
                    <p class="text-[10px] italic text-gray-500">"Serbisyong Tapat Para sa Lahat"</p>
                </div>

                <!-- BLOTTER FORM -->
                <form action="{{ route('blotter.store') }}" method="POST" id="blotterForm">
                    @csrf

                    <input type="hidden" name="case_number" value="{{ old('case_number', 'BRGY-' . date('Y') . '-' . rand(100, 999)) }}">

                    <!-- Date & Time and Status Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 uppercase mb-0.5">Date & Time</label>
                            <input type="datetime-local" name="incident_date" class="w-full border-gray-300 rounded-md shadow-sm text-xs py-1" required>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 uppercase mb-0.5">Status</label>
                            <select name="status" class="w-full border-gray-300 rounded-md shadow-sm text-xs py-1">
                                <option value="Open">Open</option>
                                <option value="Under Mediation">Under Mediation</option>
                                <option value="Settled">Settled</option>
                                <option value="Dismissed">Dismissed</option>
                                <option value="For Record Purposes Only">For Record Purposes Only</option>
                            </select>
                        </div>
                    </div>

                    <!-- Subject / Title of Incident & Location -->
                    <div class="mb-2">
                        <label class="block text-[11px] font-bold text-gray-700 uppercase mb-0.5">Subject / Title of Incident & Location</label>
                        <input type="text" name="incident_location" placeholder="Hal: MUNTIK NG MABANGGA NG VAN (Purok 3)" class="w-full border-gray-300 rounded-md shadow-sm text-xs py-1" required>
                    </div>

                    <!-- STATEMENT AND COMPLAINT -->
                    <div class="mb-2">
                        <div class="bg-gray-100 text-center py-0.5 font-bold text-[11px] text-gray-800 uppercase tracking-wider mb-1">
                            Statement and Complaint
                        </div>
                        <textarea name="complaint_details" rows="3" placeholder="Isulat dito ang buong salaysay ng reklamo o insidente..." class="w-full border-gray-300 rounded-md shadow-sm text-xs" required>{{ old('complaint_details') }}</textarea>
                    </div>

                    <!-- ACTION TAKEN BY THE BARANGAY -->
                    <div class="mb-3">
                        <div class="bg-gray-100 text-center py-0.5 font-bold text-[11px] text-gray-800 uppercase tracking-wider mb-1">
                            Action Taken by the Barangay
                        </div>
                        <textarea name="agreement_details" rows="2" placeholder="Hal: FOR THE RECORD PURPOSES ONLY" class="w-full border-gray-300 rounded-md shadow-sm text-xs"></textarea>
                    </div>

                    <!-- Complainant & Respondent Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                        <!-- Complainant -->
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 uppercase mb-0.5">Complainant:</label>
                            <input type="text" name="complainant_name" placeholder="Pangalan ng nagreklamo" class="w-full border-gray-300 rounded-md shadow-sm text-xs py-0.5 mb-0.5" required>
                            
                            <div class="border-2 border-dashed border-gray-400 rounded bg-gray-50 mb-0.5 relative" style="height: 90px;">
                                <canvas id="complainantCanvas" class="w-full h-full cursor-crosshair touch-none absolute inset-0"></canvas>
                            </div>
                            <div class="text-right mb-0.5">
                                <button type="button" onclick="clearCanvas('complainantCanvas')" class="text-[10px] text-red-600 hover:underline cursor-pointer">Clear</button>
                            </div>
                            <input type="text" value="PRINTED NAME" class="w-full text-center bg-gray-100 border-gray-300 text-[10px] font-bold py-0.5 uppercase" disabled>
                            <p class="text-center text-[9px] text-gray-500">Signature over Printed Name</p>
                        </div>

                        <!-- Respondent -->
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 uppercase mb-0.5">Respondent:</label>
                            <input type="text" name="respondent_name" placeholder="Pangalan ng inirereklamo (Opsyonal)" class="w-full border-gray-300 rounded-md shadow-sm text-xs py-0.5 mb-0.5">
                            
                            <div class="border-2 border-dashed border-gray-400 rounded bg-gray-50 mb-0.5 relative" style="height: 90px;">
                                <canvas id="respondentCanvas" class="w-full h-full cursor-crosshair touch-none absolute inset-0"></canvas>
                            </div>
                            <div class="text-right mb-0.5">
                                <button type="button" onclick="clearCanvas('respondentCanvas')" class="text-[10px] text-red-600 hover:underline cursor-pointer">Clear</button>
                            </div>
                            <input type="text" value="PRINTED NAME" class="w-full text-center bg-gray-100 border-gray-300 text-[10px] font-bold py-0.5 uppercase" disabled>
                            <p class="text-center text-[9px] text-gray-500">Signature over Printed Name</p>
                        </div>
                    </div>

                    <!-- Lupon on Duty / Witness -->
                    <div class="mb-4 max-w-sm mx-auto">
                        <label class="block text-[11px] font-bold text-gray-700 uppercase mb-0.5">Lupon on Duty / Witness:</label>
                        <input type="text" name="lupon_name" placeholder="Pangalan ng Lupon / Witness" class="w-full border-gray-300 rounded-md shadow-sm text-xs py-0.5 mb-0.5">
                        
                        <div class="border-2 border-dashed border-gray-400 rounded bg-gray-50 mb-0.5 relative" style="height: 80px;">
                            <canvas id="luponCanvas" class="w-full h-full cursor-crosshair touch-none absolute inset-0"></canvas>
                        </div>
                        <div class="text-right mb-0.5">
                            <button type="button" onclick="clearCanvas('luponCanvas')" class="text-[10px] text-red-600 hover:underline cursor-pointer">Clear</button>
                        </div>
                        <input type="text" value="PRINTED NAME" class="w-full text-center bg-gray-100 border-gray-300 text-[10px] font-bold py-0.5 uppercase" disabled>
                        <p class="text-center text-[9px] text-gray-500">Signature over Printed Name</p>
                    </div>

                    <!-- ACTION BUTTONS (Inilabas natin ang mga ito sa pinakataas ng stacking context para madaling mapindot) -->
                    <div class="space-y-2 no-print relative z-50">
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded shadow transition text-center text-sm cursor-pointer relative z-50">
                            💾 Save Blotter & Signatures
                        </button>
                        
                        <button type="button" onclick="printBlotterForm()" class="w-full bg-sky-600 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded shadow transition text-center text-sm cursor-pointer relative z-50">
                            🖨️ Print Blotter Form
                        </button>

                        <div class="text-center pt-1">
                            <a href="{{ route('blotter.index') }}" class="text-xs text-gray-600 hover:underline">← Back to Blotter Records</a>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script>
        function printBlotterForm() {
            window.print();
        }

        function setupCanvas(canvasId) {
            const canvas = document.getElementById(canvasId);
            if (!canvas) return;
            const ctx = canvas.getContext('2d');

            function resize() {
                const rect = canvas.getBoundingClientRect();
                if (rect.width > 0 && rect.height > 0) {
                    canvas.width = rect.width;
                    canvas.height = rect.height;
                }
            }
            resize();
            window.addEventListener('resize', resize);

            let isDrawing = false;
            let lastX = 0;
            let lastY = 0;

            function getPosition(e) {
                const rect = canvas.getBoundingClientRect();
                const clientX = e.clientX || (e.touches ? e.touches[0].clientX : 0);
                const clientY = e.clientY || (e.touches ? e.touches[0].clientY : 0);
                return {
                    x: clientX - rect.left,
                    y: clientY - rect.top
                };
            }

            function startDrawing(e) {
                isDrawing = true;
                const pos = getPosition(e);
                lastX = pos.x;
                lastY = pos.y;
            }

            function draw(e) {
                if (!isDrawing) return;
                e.preventDefault();
                const pos = getPosition(e);

                ctx.strokeStyle = '#000000';
                ctx.lineWidth = 2;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';

                ctx.beginPath();
                ctx.moveTo(lastX, lastY);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();

                lastX = pos.x;
                lastY = pos.y;
            }

            function stopDrawing() {
                isDrawing = false;
            }

            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('mouseup', stopDrawing);
            canvas.addEventListener('mouseleave', stopDrawing);

            canvas.addEventListener('touchstart', startDrawing);
            canvas.addEventListener('touchmove', draw);
            canvas.addEventListener('touchend', stopDrawing);
        }

        function clearCanvas(canvasId) {
            const canvas = document.getElementById(canvasId);
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }

        document.addEventListener('DOMContentLoaded', () => {
            setupCanvas('complainantCanvas');
            setupCanvas('respondentCanvas');
            setupCanvas('luponCanvas');
        });
    </script>
</x-app-layout>