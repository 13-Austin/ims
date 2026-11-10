<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ➕ Register New Resident (Comprehensive Profiling)
            </h2>
            <a href="{{ route('residents.index') }}" class="inline-flex items-center bg-gray-600 hover:bg-gray-700 text-white text-sm font-semibold py-2 px-4 rounded-md shadow transition">
                ← Back to Directory
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('residents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Full Name -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">First Name</label>
                                <input type="text" name="first_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Middle Name</label>
                                <input type="text" name="middle_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Last Name</label>
                                <input type="text" name="last_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                        </div>

                        <!-- Birthdate, Gender, Civil Status -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Birthdate</label>
                                <input type="date" id="birthdate" name="birthdate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Gender</label>
                                <select name="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Select...</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Civil Status</label>
                                <select id="civil_status" name="civil_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Select...</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed/Divorced</option>
                                    <option value="Separated">Separated</option>
                                </select>
                            </div>
                        </div>

                        <!-- AUTO-COMPUTED / TAGGED BADGES SUMMARY -->
                        <div class="bg-blue-50 border border-blue-200 p-4 rounded-md mb-4">
                            <span class="block text-xs font-bold text-blue-900 mb-2">📋 Auto-Classified Status (Automatically assessed based on age and civil status):</span>
                            <div class="flex flex-wrap gap-2 items-center">
                                <span id="badge-age-group" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-200 text-gray-800">Age Group: -</span>
                                <span id="badge-senior" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-300" style="display:none;">👴 Senior Citizen</span>
                                <span id="badge-soloparent" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-300" style="display:none;">🛡️ Potential Solo Parent</span>
                            </div>
                            <input type="hidden" name="age_group" id="input_age_group">
                            <input type="hidden" name="is_senior" id="input_is_senior" value="0">
                            <input type="hidden" name="is_solo_parent" id="input_is_solo_parent" value="0">
                        </div>

                        <!-- Purok, Contact, Head of Family -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Purok / Sitio</label>
                                <input type="text" name="purok_sitio" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ex. Purok 1" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                                <input type="text" name="contact_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="09XXXXXXXXX">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Head of the Family?</label>
                                <select name="is_head_family" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes (Household Head)</option>
                                </select>
                            </div>
                        </div>

                        <!-- IP, 4Ps, Student Checkboxes / Selects -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Indigenous People (IP)?</label>
                                <select name="is_ip" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">4Ps Beneficiary?</label>
                                <select name="is_4ps" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Student Status?</label>
                                <select name="is_student" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>

                        <!-- EMPLOYMENT & OFW SECTION -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 border-t pt-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Employment Status</label>
                                <select id="employment_status" name="employment_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="Unemployed">Unemployed</option>
                                    <option value="Employed">Employed</option>
                                    <option value="Self-Employed">Self-Employed</option>
                                    <option value="OFW">OFW (Overseas Filipino Worker)</option>
                                </select>
                            </div>
                            <div id="workplace-container" style="display:none;">
                                <label class="block text-sm font-medium text-gray-700">Workplace / Company</label>
                                <input type="text" name="workplace" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ex. Olongapo City / Factory">
                            </div>
                            <div id="country-container" style="display:none;">
                                <label class="block text-sm font-medium text-gray-700">Country of Work</label>
                                <input type="text" name="ofw_country" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ex. Taiwan, Saudi Arabia, Japan">
                            </div>
                        </div>

                        <!-- PWD SECTION -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 border-t pt-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Person with Disability (PWD)?</label>
                                <select id="is_pwd" name="is_pwd" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div id="pwd-type-container" class="md:col-span-2" style="display:none;">
                                <label class="block text-sm font-medium text-gray-700">Disability Type (PWD Type)</label>
                                <input type="text" name="pwd_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ex. Visual, Hearing, Orthopedic, Intellectual, etc.">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Voter Status</label>
                            <select name="is_voter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="1">Registered Voter</option>
                                <option value="0">Not a Voter</option>
                            </select>
                        </div>

                        <!-- RESIDENT PHOTO: WEBCAM CAPTURE & FILE UPLOAD -->
                        <div class="mb-6 p-4 border rounded-lg bg-gray-50">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Resident Photo</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                                <div class="text-center border-b md:border-b-0 md:border-r pb-4 md:pb-0 md:pr-4">
                                    <p class="text-xs text-gray-500 mb-2">Live Webcam Feed</p>
                                    <video id="webcam" autoplay playsinline class="w-full max-w-xs mx-auto h-40 rounded-md bg-black object-cover shadow"></video>
                                    <div class="mt-2">
                                        <button type="button" id="capture-btn" class="bg-gray-800 hover:bg-gray-900 text-white text-xs font-semibold py-1.5 px-3 rounded shadow">📸 Capture Photo</button>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <p class="text-xs text-gray-500 mb-2">Captured / Selected Preview</p>
                                    <canvas id="canvas" style="display: none;"></canvas>
                                    <div class="flex justify-center mb-3">
                                        <img id="photo-preview" src="#" alt="Preview" class="w-24 h-24 rounded-full object-cover shadow border" style="display: none;">
                                        <div id="no-photo-box" class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center text-xs text-gray-500 font-semibold mx-auto border">
                                            No Photo Yet
                                        </div>
                                    </div>
                                    <div>
                                        <input type="file" name="photo" id="photo-input" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Complete Address</label>
                            <textarea name="address" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                        </div>

                        <div class="flex justify-between items-center">
                            <a href="{{ route('residents.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-semibold">Back</a>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-semibold">Save Resident</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT FOR WEBCAM AND AUTO-COMPUTATION LOGIC -->
    <script>
        const birthdateInput = document.getElementById('birthdate');
        const civilStatusSelect = document.getElementById('civil_status');
        
        const badgeAgeGroup = document.getElementById('badge-age-group');
        const badgeSenior = document.getElementById('badge-senior');
        const badgeSoloParent = document.getElementById('badge-soloparent');

        const inputAgeGroup = document.getElementById('input_age_group');
        const inputIsSenior = document.getElementById('input_is_senior');
        const inputIsSoloParent = document.getElementById('input_is_solo_parent');

        function computeResidentDetails() {
            const birthdateVal = birthdateInput.value;
            if (!birthdateVal) return;

            const dob = new Date(birthdateVal);
            const today = new Date();
            
            let age = today.getFullYear() - dob.getFullYear();
            const m = today.getMonth() - dob.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            let ageGroup = 'Adult';
            if (age < 1) {
                ageGroup = 'Infant';
            } else if (age >= 1 && age < 18) {
                ageGroup = 'Child';
            } else {
                ageGroup = 'Adult';
            }

            badgeAgeGroup.textContent = `Age: ${age} yrs old (${ageGroup})`;
            inputAgeGroup.value = ageGroup;

            if (age >= 60) {
                badgeSenior.style.display = 'inline-flex';
                inputIsSenior.value = 1;
            } else {
                badgeSenior.style.display = 'none';
                inputIsSenior.value = 0;
            }

            const civilVal = civilStatusSelect.value;
            if (civilVal === 'Widowed' || civilVal === 'Separated') {
                badgeSoloParent.style.display = 'inline-flex';
                inputIsSoloParent.value = 1;
            } else {
                badgeSoloParent.style.display = 'none';
                inputIsSoloParent.value = 0;
            }
        }

        birthdateInput.addEventListener('change', computeResidentDetails);
        civilStatusSelect.addEventListener('change', computeResidentDetails);

        const employmentStatus = document.getElementById('employment_status');
        const workplaceContainer = document.getElementById('workplace-container');
        const countryContainer = document.getElementById('country-container');

        employmentStatus.addEventListener('change', function() {
            const val = this.value;
            workplaceContainer.style.display = 'none';
            countryContainer.style.display = 'none';

            if (val === 'Employed' || val === 'Self-Employed') {
                workplaceContainer.style.display = 'block';
            } else if (val === 'OFW') {
                countryContainer.style.display = 'block';
            }
        });

        const isPwdSelect = document.getElementById('is_pwd');
        const pwdTypeContainer = document.getElementById('pwd-type-container');

        isPwdSelect.addEventListener('change', function() {
            if (this.value === '1') {
                pwdTypeContainer.style.display = 'block';
            } else {
                pwdTypeContainer.style.display = 'none';
            }
        });

        const video = document.getElementById('webcam');
        const canvas = document.getElementById('canvas');
        const captureBtn = document.getElementById('capture-btn');
        const photoPreview = document.getElementById('photo-preview');
        const noPhotoBox = document.getElementById('no-photo-box');
        const fileInput = document.getElementById('photo-input');

        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => { video.srcObject = stream; })
            .catch(err => { console.error("Webcam error: ", err); });

        captureBtn.addEventListener('click', () => {
            canvas.width = video.videoWidth || 640;
            canvas.height = video.videoHeight || 480;
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            canvas.toBlob(blob => {
                const file = new File([blob], "webcam_capture.png", { type: "image/png" });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;

                const imageUrl = URL.createObjectURL(blob);
                photoPreview.src = imageUrl;
                photoPreview.style.display = 'block';
                noPhotoBox.style.display = 'none';
            }, 'image/png');
        });

        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const imageUrl = URL.createObjectURL(file);
                photoPreview.src = imageUrl;
                photoPreview.style.display = 'block';
                noPhotoBox.style.display = 'none';
            }
        });
    </script>
</x-app-layout>[cite: 16]