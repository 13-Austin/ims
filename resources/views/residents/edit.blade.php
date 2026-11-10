<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Resident Information') }}
            </h2>
            <a href="{{ route('residents.index') }}" class="inline-flex items-center bg-gray-600 hover:bg-gray-700 text-white text-sm font-semibold py-2 px-4 rounded-md shadow transition">
                ← Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('residents.update', $resident->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- PHOTO UPDATE SECTION (WEBCAM & UPLOAD) -->
                        <div class="mb-6 p-4 border rounded-lg bg-gray-50">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Resident Photo</label>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                                <!-- Kaliwa: Live Webcam Feed -->
                                <div class="text-center border-b md:border-b-0 md:border-r pb-4 md:pb-0 md:pr-4">
                                    <p class="text-xs text-gray-500 mb-2">Live Webcam Capture</p>
                                    <video id="webcam" autoplay playsinline class="w-full max-w-xs mx-auto h-40 rounded-md bg-black object-cover shadow"></video>
                                    <div class="mt-2">
                                        <button type="button" id="capture-btn" class="bg-gray-800 hover:bg-gray-900 text-white text-xs font-semibold py-1.5 px-3 rounded shadow">
                                            📸 Capture Picture
                                        </button>
                                    </div>
                                </div>

                                <!-- Kanan: Current / Preview / File Upload -->
                                <div class="text-center">
                                    <p class="text-xs text-gray-500 mb-2">Current / New Preview</p>
                                    <canvas id="canvas" style="display: none;"></canvas>
                                    
                                    <div class="flex justify-center mb-3">
                                        @if($resident->photo)
                                            <img id="photo-preview" src="{{ asset('storage/' . $resident->photo) }}" alt="Resident Photo" class="w-24 h-24 rounded-full object-cover shadow border">
                                        @else
                                            <img id="photo-preview" src="#" alt="Preview" class="w-24 h-24 rounded-full object-cover shadow border" style="display: none;">
                                            <div id="no-photo-box" class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center text-xs text-gray-500 font-semibold mx-auto border">
                                                No Photo
                                            </div>
                                        @endif
                                    </div>

                                    <!-- File input (hidden or styled) -->
                                    <div>
                                        <input type="file" name="photo" id="photo-input" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    </div>
                                </div>
                            </div>

                            @error('photo')
                                <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">First Name</label>
                                <input type="text" name="first_name" value="{{ old('first_name', $resident->first_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Middle Name</label>
                                <input type="text" name="middle_name" value="{{ old('middle_name', $resident->middle_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Last Name</label>
                                <input type="text" name="last_name" value="{{ old('last_name', $resident->last_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Birthdate</label>
                                <input type="date" name="birthdate" value="{{ old('birthdate', $resident->birthdate) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Gender</label>
                                <select name="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="Male" {{ $resident->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $resident->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Civil Status</label>
                                <select name="civil_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="Single" {{ $resident->civil_status == 'Single' ? 'selected' : '' }}>Single</option>
                                    <option value="Married" {{ $resident->civil_status == 'Married' ? 'selected' : '' }}>Married</option>
                                    <option value="Widowed" {{ $resident->civil_status == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Purok / Sitio</label>
                                <input type="text" name="purok_sitio" value="{{ old('purok_sitio', $resident->purok_sitio) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Employment Status</label>
                                <input type="text" name="employment_status" value="{{ old('employment_status', $resident->employment_status) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                                <input type="text" name="contact_number" value="{{ old('contact_number', $resident->contact_number) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Voter Status</label>
                            <select name="is_voter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="1" {{ $resident->is_voter == 1 ? 'selected' : '' }}>Registered Voter</option>
                                <option value="0" {{ $resident->is_voter == 0 ? 'selected' : '' }}>Not a Voter</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Complete Address</label>
                            <textarea name="address" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('address', $resident->address) }}</textarea>
                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ route('residents.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-semibold">Cancel</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-semibold">Update Resident</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- WEBCAM & PREVIEW JAVASCRIPT -->
    <script>
        const video = document.getElementById('webcam');
        const canvas = document.getElementById('canvas');
        const captureBtn = document.getElementById('capture-btn');
        const photoPreview = document.getElementById('photo-preview');
        const noPhotoBox = document.getElementById('no-photo-box');
        const fileInput = document.getElementById('photo-input');

        // 1. I-on ang Webcam sa pagbukas ng edit page
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(err => {
                console.error("Hindi ma-access ang webcam: ", err);
            });

        // 2. Kunin ang litrato mula sa video stream kapag pinindot ang button
        captureBtn.addEventListener('click', () => {
            canvas.width = video.videoWidth || 640;
            canvas.height = video.videoHeight || 480;
            
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            canvas.toBlob(blob => {
                const file = new File([blob], "webcam_update.png", { type: "image/png" });
                
                // Ilagay ang nakuhaang file sa file input gamit ang DataTransfer
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;

                // Ipakita ang bagong preview at itago ang placeholder box
                const imageUrl = URL.createObjectURL(blob);
                photoPreview.src = imageUrl;
                photoPreview.style.display = 'block';
                if (noPhotoBox) {
                    noPhotoBox.style.display = 'none';
                }
            }, 'image/png');
        });

        // 3. I-update ang preview kung mano-mano namang nag-upload ng file gamit ang file input
        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const imageUrl = URL.createObjectURL(file);
                photoPreview.src = imageUrl;
                photoPreview.style.display = 'block';
                if (noPhotoBox) {
                    noPhotoBox.style.display = 'none';
                }
            }
        });
    </script>
</x-app-layout>