<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate - {{ $document->control_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @page {
            size: auto;
            margin: 0mm;
        }

        @media print {
            .no-print { display: none !important; }
            body, html { 
                background: white !important; 
                margin: 0 !important; 
                padding: 0 !important; 
                width: 100% !important;
                height: 100% !important;
            }
            .main-wrapper {
                margin: 0 !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
            .certificate-container { 
                border: none !important; 
                box-shadow: none !important; 
                margin: 0 !important;
                width: 100vw !important;
                height: 100vh !important;
                max-height: 100vh !important;
                page-break-after: avoid !important;
                page-break-inside: avoid !important;
                background-image: url("{{ asset('images/certificate_template.png') }}") !important;
                background-size: 100% 100% !important;
                background-position: center !important;
                background-repeat: no-repeat !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }

        body {
            background: #e9ecef;
            margin: 0;
            padding: 20px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .main-wrapper {
            width: 100%;
            max-width: 215.9mm;
            margin: auto;
        }

        .certificate-container {
            position: relative;
            background-color: #fff;
            background-image: url("{{ asset('images/certificate_template.png') }}");
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
            width: 215.9mm;
            min-height: 279.4mm;
            margin: 0 auto;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 45px 75px 40px 75px;
        }

        .cert-content {
            position: relative;
            z-index: 10;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .header-logos {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-logos img {
            height: 55px;
            width: 55px;
            object-fit: contain;
        }

        .dry-seal-box {
            width: 75px;
            height: 75px;
            border: 2px dashed #555;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 6.5px;
            color: #333;
            margin: auto;
            background: rgba(255, 255, 255, 0.9);
        }
    </style>
</head>
<body>

    <div class="main-wrapper my-2">
        <div class="no-print mb-3 d-flex justify-content-between align-items-center" style="max-width: 215.9mm; margin: 0 auto 15px auto;">
            <a href="{{ route('documents.index') }}" class="btn btn-secondary btn-sm">← BACK</a>
            
            <!-- OPTION PARA MAG-TYPE NG CUSTOM PURPOSE KUNG KAKAILANGANIN -->
            <div class="no-print input-group input-group-sm w-50">
                <span class="input-group-text bg-dark text-white">Purpose:</span>
                <select id="purposeSelect" class="form-select form-select-sm" onchange="handlePurposeChange(this)">
                    <option value="{{ strtoupper($document->purpose ?? 'GENERAL PURPOSES') }}">Default: {{ strtoupper($document->purpose ?? 'GENERAL PURPOSES') }}</option>
                    <option value="CUSTOM">Type custom purpose...</option>
                </select>
                <input type="text" id="customPurposeInput" class="form-control form-control-sm" placeholder="I-type ang layunin dito..." style="display: none;" oninput="updatePurposeText(this)">
            </div>

            <div class="d-flex gap-2">
                <button onclick="window.print()" class="btn btn-success btn-sm fw-bold">🖨️ PRINT</button>
            </div>
        </div>

        <div class="certificate-container">
            <div class="cert-content">
                
                <!-- ITAAS NA BAHAGI -->
                <div>
                    <div class="header-logos px-2 mb-2">
                        <img src="{{ asset('images/barangay_logo.png') }}" alt="Barangay Logo">
                        <div class="text-center text-dark fw-bold" style="font-size: 12.5px; line-height: 1.35;">
                            Republic of the Philippines<br>
                            Province of Zambales <br>
                            Municipality of Castillejos<br>
                            <span style="font-size: 15.5px; letter-spacing: 1.5px;" class="text-uppercase text-success">Barangay Magsaysay</span>
                        </div>
                        <div class="d-flex gap-2">
                            <img src="{{ asset('images/municipality_logo.png') }}" alt="Municipality Logo">
                            <img src="{{ asset('images/bagong_pilipinas.png') }}" alt="Bagong Pilipinas Logo">
                        </div>
                    </div>

                    <div class="text-center mb-3 pb-1 border-bottom">
                        <h3 class="fw-bold text-uppercase mt-1 text-dark" style="letter-spacing: 2.5px; text-decoration: underline; color: #d35400 !important; font-size: 25px;">
                            {{ $document->document_type }}
                        </h3>
                    </div>
                </div>

                <!-- GITNANG BAHAGI -->
                <div class="my-auto px-2">
                    <div class="d-flex justify-content-between small text-dark fw-bold mb-3 px-3" style="font-size: 13.5px;">
                        <div><strong>Control No:</strong> {{ $document->control_number }}</div>
                        <div><strong>Date Issued:</strong> {{ optional($document->issued_at)->format('F d, Y') ?? date('F d, Y') }}</div>
                    </div>

                    <div style="font-size: 1.3rem; line-height: 2.0; text-align: justify; color: #000;">
                        <p class="fw-bold mb-3">TO WHOM IT MAY CONCERN:</p>

                        <p style="text-indent: 60px;" class="mb-3">
                            This is to certify that <strong>{{ strtoupper($document->resident->first_name . ' ' . ($document->resident->middle_name ? $document->resident->middle_name[0] . '. ' : '') . $document->resident->last_name) }}</strong>, 
                            legal age, <strong>{{ $document->resident->civil_status }}</strong>, Filipino, is a bona fide resident of {{ $document->resident->purok_sitio }}, Barangay Magsaysay, Castillejos, Zambales.
                        </p>

                        <p style="text-indent: 60px;" class="mb-3">
                            This certification is issued upon the request of the above-named person for the purpose of: 
                            <strong id="displayPurpose">{{ strtoupper($document->purpose ?? 'GENERAL PURPOSES') }}</strong>.
                        </p>

                        <p style="text-indent: 60px;" class="mb-0">
                            Issued this <strong>{{ date('jS') }}</strong> day of <strong>{{ date('F, Y') }}</strong> at the Barangay Hall of Barangay Magsaysay, Castillejos, Zambales, Philippines.
                        </p>
                    </div>
                </div>

                <!-- IBABANG BAHAGI -->
                <div>
                    <div class="row pt-2 align-items-end px-2 mb-3">
                        <div class="col-6 text-center">
                            <div class="dry-seal-box">
                                AFFIX<br>BARANGAY<br>DRY SEAL HERE<br>
                                <small class="text-dark fw-bold">{{ $document->dry_seal_number ?? 'DS-PENDING' }}</small>
                            </div>
                        </div>

                        <div class="col-6 text-center">
                            <p class="mb-1 text-muted small" style="font-size: 12px;">Approved & Authorized By:</p>
                            <h5 class="fw-bold text-uppercase mb-0 text-decoration-underline" style="color: #196f3d; font-size: 18.5px;">
                                {{ $document->signatory_name ?? 'HON. ALOHA CUA-BAUTISTA' }}
                            </h5>
                            <p class="text-secondary small fw-bold mt-1 mb-0" style="font-size: 12px;">
                                {{ $document->signatory_title ?? 'Punong Barangay' }}
                            </p>
                        </div>
                    </div>

                    <div class="pt-2 border-top text-muted px-2" style="font-size: 8px;">
                        <div class="row">
                            <div class="col-6">
                                <strong>System Traceability Audit Log:</strong><br>
                                Processed by: {{ optional($document->processor)->name ?? 'System Admin' }} | 
                                Approved by: {{ optional($document->approver)->name ?? 'Pending' }}
                            </div>
                            <div class="col-6 text-end">
                                <strong>Dry Seal Tracking:</strong> {{ $document->dry_seal_number ?? 'N/A' }}<br>
                                <em>Brgy. Magsaysay Information Management System (IMS).</em>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- JAVASCRIPT PARA SA CUSTOM TYPING NG PURPOSE -->
    <script>
        function handlePurposeChange(select) {
            const customInput = document.getElementById('customPurposeInput');
            const displayPurpose = document.getElementById('displayPurpose');

            if (select.value === 'CUSTOM') {
                customInput.style.display = 'block';
                customInput.focus();
                displayPurpose.textContent = customInput.value ? customInput.value.toUpperCase() : '(I-type ang layunin...)';
            } else {
                customInput.style.display = 'none';
                displayPurpose.textContent = select.value;
            }
        }

        function updatePurposeText(input) {
            const displayPurpose = document.getElementById('displayPurpose');
            displayPurpose.textContent = input.value ? input.value.toUpperCase() : '(I-type ang layunin...)';
        }
    </script>
</body>
</html>