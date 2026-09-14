@extends('layouts.master')

@section('title','Hospitals')
@section('page-title', 'Papua New Guinea Medical Facility')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    #map {
        height: 700px;
    }
    .filter-container {
        margin-bottom: 20px;
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,.1);
    }
    .form-check-scrollable {
        max-height: 150px;
        overflow-y: auto;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
    }
    .total-hospital {
        background: white;
        padding: 8px 12px;
        border-radius: 8px;
        box-shadow: 0 0 6px rgba(0,0,0,0.2);
        font-weight: bold;
    }
    .select2-container .select2-selection--single {
        height: 45px;
        padding: 6px 12px;
        border: 1px solid #ced4da;
        border-radius: 10px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 30px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 45px;
        right: 10px;
    }

     .p-modal{
        text-align:justify;
    }

       .btn-danger{
            background-color:#395272;
            border-color: transparent;
        }

        .btn-danger:hover{
            background-color:#5686c3;
            border-color: transparent;
        }

        .btn.active {
            background-color: #5686c3 !important;
            border-color: transparent !important;
            color: #fff !important;
        }

        .p-3{
            padding: 10px !important;
            margin: 0 3px;
        }

        .btn-outline-danger{
            color: #FFFFFF;
            background-color:#395272;
            border-color: transparent;
        }

        .btn-outline-danger:hover{
            background-color:#5686c3;
            border-color: transparent;
        }

        .fa,
        .fab,
        .fad,
        .fal,
        .far,
        .fas {
            color: #346abb;
        }

        .card-header{
            padding: 0.25rem 1.25rem;
            color: #3c66b5;
            font-weight: bold;
        }

        .mb-4{
            margin-bottom: 0.5rem !important;
        }

        /* Classification */
        .advanced{
            border-bottom: 3px solid #397fff;
        }

        .intermediete{
            border-bottom: 3px solid #48d12c;
        }

        .basic{
            border-bottom: 3px solid #b4a911ff;
        }

        /* Boder */
        .bl{
            border-left: 2px solid #DDDDDD;
        }

        .br{
            border-right: 2px solid #DDDDDD;
        }

        /* ===== Filter panel: district dropdown ===== */
        .select-input {
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 8px 10px;
            background: #fff;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .select-input input {
            border: none;
            width: 100%;
            cursor: pointer;
            background: transparent;
            outline: none;
        }

        .select-dropdown {
            display: none;
            position: absolute;
            width: 100%;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-top: 3px;
            z-index: 9999;
            max-height: 250px;
            overflow: hidden;
        }

        .select-dropdown.show {
            display: block;
        }

        .dropdown-search {
            width: 100%;
            border: none;
            border-bottom: 1px solid #ddd;
            padding: 8px;
            outline: none;
        }

        #provinceList {
            list-style: none;
            padding: 0;
            margin: 0;
            max-height: 180px;
            overflow-y: auto;
        }

        #provinceList li {
            padding: 5px 10px;
        }

        #provinceList li:hover {
            background: #f5f5f5;
        }

        #provinceList label {
            width: 100%;
            margin: 0;
            cursor: pointer;
        }

        /* ===== Google Places Autocomplete Fix ===== */
        .pac-container {
            z-index: 99999 !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 16px rgba(0,0,0,0.2) !important;
            font-family: inherit !important;
            margin-top: 2px !important;
            border: 1px solid #ddd !important;
        }

        .pac-item {
            padding: 6px 12px !important;
            cursor: pointer !important;
            font-size: 13px !important;
            border-top: 1px solid #f0f0f0 !important;
        }

        .pac-item:hover {
            background: #f0f6ff !important;
        }

        .pac-item-query {
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #333 !important;
        }

        .pac-matched {
            color: #1a73e8 !important;
            font-weight: 700 !important;
        }

        #locationSearchMap:focus {
            outline: none !important;
            border-color: #1a73e8 !important;
            box-shadow: 0 0 0 2px rgba(26,115,232,0.2) !important;
        }

    #level11Modal .modal-dialog,
    #level55Modal .modal-dialog,
    #level66Modal .modal-dialog {
        width: calc(100% - 32px);
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }
    #level11Modal .modal-content,
    #level55Modal .modal-content,
    #level66Modal .modal-content {
        max-height: calc(100dvh - 64px);
    }
    #level11Modal .modal-header,
    #level55Modal .modal-header,
    #level66Modal .modal-header,
    #level11Modal .nav-tabs,
    #level55Modal .nav-tabs,
    #level66Modal .nav-tabs {
        flex-shrink: 0;
    }
    #level11Modal .modal-body,
    #level55Modal .modal-body,
    #level66Modal .modal-body {
        overflow-y: auto;
        min-height: 0;
    }
    #clinicTabs,
    #secondaryTabs,
    #tertiaryTabs {
        gap: 4px;
        border-bottom: 1px solid #dee2e6;
    }
    #clinicTabs .nav-item,
    #secondaryTabs .nav-item,
    #tertiaryTabs .nav-item {
        margin-bottom: -1px;
    }
    #clinicTabs .nav-link,
    #secondaryTabs .nav-link,
    #tertiaryTabs .nav-link {
        padding: 10px 14px;
        border: 1px solid transparent;
        border-radius: 4px 4px 0 0;
        background: #f0f0f0;
        color: #111;
        font-size: 12px;
        font-weight: 700;
        line-height: 16px;
    }
    #clinicTabs .nav-link.active,
    #secondaryTabs .nav-link.active,
    #tertiaryTabs .nav-link.active {
        background: #fff;
        color: #555d65;
        border-color: #dee2e6 #dee2e6 #fff;
    }
    #level11Modal p,
    #level55Modal p,
    #level66Modal p,
    #level11Modal li,
    #level55Modal li,
    #level66Modal li {
        line-height: 1.6;
    }
    #level11Modal li,
    #level55Modal li,
    #level66Modal li {
        margin-bottom: 4px;
    }
</style>
@endpush

@section('conten')

<div class="card">

    <div class="d-flex justify-content-end p-3" style="background-color: #dfeaf1;">

        <div class="d-flex gap-2 mt-2">

            <a href="{{ url('home') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('home') ? 'active' : '' }}">
                <i class="bi bi-house-door-fill fs-3"></i>
                <small>Home</small>
            </a>

            <a href="{{ url('airports') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports') ? 'active' : '' }}">
                <i class="bi bi-airplane fs-3"></i>
                <small>Aviation</small>
            </a>

            <a href="{{ url('hospital') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospital') ? 'active' : '' }}">
             <img src="{{ asset('images/icon-medical.png') }}" style="width: 24px; height: 24px;">
                <small>Medical</small>
            </a>

            <a href="{{ url('police') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('police') ? 'active' : '' }}">
                <i class="bi bi-person-badge" style="width: 24px; height: 24px;"></i>
                <small>Police</small>
            </a>

            <a href="{{ url('embassiees') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('embassiees') ? 'active' : '' }}">
            <img src="{{ asset('images/icon-embassy.png') }}" style="width: 24px; height: 24px;">
                <small>Embassies</small>
            </a>

        </div>
    </div>

    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center gap-3 my-2">

        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-link p-0 fw-bold text-decoration-underline text-dark" data-bs-toggle="modal" data-bs-target="#disclaimerModal">
                <i class="bi bi-info-circle text-primary fs-5"></i>
                Disclaimer
            </button>
        </div>

        <div class="d-flex align-items-end gap-3">
            <div style="margin-right:20px;">
                <span class="fw-bold pb-2 d-inline-block">Classification:</span>
            </div>
            <!-- Classification -->
            <div class="text-end" style="min-width: 700px;">
                <div class="row">
                    <div class="col-3 text-center fw-bold advanced br">Advanced</div>
                    <div class="col-3 text-center fw-bold intermediete br">Intermediate</div>
                    <div class="col-3 text-center fw-bold basic">Basic</div>
                </div>

                <div class="row text-center">
                <!-- Advanced -->
                    <div class="col-3 text-danger br">
                        <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level66Modal">
                            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital-pin-red.png" style="width:30px; height:30px;">
                            <small>Tertiary</small>
                        </button>
                    </div>

                    <!-- Intermediete -->
                     <div class="col-3 text-primary br">
                        <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level55Modal">
                            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-blue.png" style="width:30px; height:30px;">
                            <small>Secondary</small>
                        </button>
                    </div>

                    <!-- Basic -->
                    <div class="col-3 text-info">
                        <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level11Modal">
                            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-tosca.png" style="width:30px; height:30px;">
                            <small>Clinic / Health Center</small>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        </div>
    </div>

</div>


<div class="modal fade" id="disclaimerModal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="disclaimerLabel">Disclaimer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">Every attempt has been made to ensure the completeness and accuracy of the most updated information and data available. Clients are advised, however, that provided information, and data is subject to change.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level11Modal" tabindex="-1" aria-labelledby="clinicModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center" style="gap:8px;">
          <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-tosca.png" alt="" style="width:30px; height:30px;">
          <h5 class="modal-title" id="clinicModalLabel">Clinic / Health Center</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <ul class="nav nav-tabs px-3 pt-2" id="clinicTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="clinic-overview-tab" data-bs-toggle="tab" data-bs-target="#clinic-overview" type="button" role="tab" aria-controls="clinic-overview" aria-selected="true">Overview</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="clinic-role-tab" data-bs-toggle="tab" data-bs-target="#clinic-role" type="button" role="tab" aria-controls="clinic-role" aria-selected="false">Role</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="clinic-clinical-tab" data-bs-toggle="tab" data-bs-target="#clinic-clinical" type="button" role="tab" aria-controls="clinic-clinical" aria-selected="false">Clinical Services</button>
        </li>
      </ul>
      <div class="modal-body tab-content">
        <div class="tab-pane fade show active" id="clinic-overview" role="tabpanel" aria-labelledby="clinic-overview-tab" tabindex="0">
          <p>Government health centres and health clinics are the main first-contact facilities for community healthcare in Brunei Darussalam. They provide accessible services by catchment area, focus on prevention and early detection, manage common illnesses and chronic conditions, and refer patients to hospital emergency departments or specialist clinics when higher-level care is required.</p>
          <p><strong>Note:</strong> The Ministry of Health uses the terms Health Centre and Health Clinic. Published public sources do not establish a single nationwide licence class or bed-capacity rule distinguishing the two. In practice, larger health centres usually provide a broader multidisciplinary service package, while smaller health clinics provide narrower community, maternal-child, or remote-area services.</p>
        </div>
        <div class="tab-pane fade" id="clinic-role" role="tabpanel" aria-labelledby="clinic-role-tab" tabindex="0">
          <ul>
            <li>Provide first-contact care for common and uncomplicated health conditions</li>
            <li>Deliver disease prevention, screening, early detection, treatment, and chronic-disease follow-up</li>
            <li>Provide maternal, postnatal, child-health, immunisation, and well-woman services</li>
            <li>Provide wound care, injections, point-of-care testing, health counselling, and preventive services</li>
            <li>Support home-based nursing and community outreach where assigned</li>
            <li>Refer patients to emergency departments, hospital wards, specialist clinics, and allied-health services</li>
          </ul>
        </div>
        <div class="tab-pane fade" id="clinic-clinical" role="tabpanel" aria-labelledby="clinic-clinical-tab" tabindex="0">
          <h6><strong>Bed Capacity</strong></h6>
          <ul>
            <li>Health centres and health clinics are generally outpatient facilities</li>
            <li>Observation rooms may be used for short monitoring and stabilisation</li>
            <li>They do not normally provide full hospital inpatient wards, operating theatres, or intensive-care units</li>
          </ul>
          <h6><strong>Core Services</strong></h6>
          <ul>
            <li>General outpatient and primary medical care</li>
            <li>Chronic-disease management</li>
            <li>Maternal and child health</li>
            <li>Immunisation and national health screening</li>
            <li>Health education, counselling, and prevention</li>
            <li>Dental care at designated centres and clinics</li>
            <li>Community nursing and home visits</li>
          </ul>
          <h6><strong>Intermediate Services</strong></h6>
          <ul>
            <li>Nurse-led diabetes education, foot screening, smoking cessation, Pap testing, and health-screening clinics</li>
            <li>Antenatal assessment, ultrasound at designated sites, postnatal care, and breastfeeding support</li>
            <li>Child-development monitoring and vaccination for children aged 0–5 years</li>
            <li>Visiting dietetics, psychology, psychiatry, eye, podiatry, rehabilitation, and other services at selected centres</li>
            <li>Medical fitness examinations and report preparation for authorised categories</li>
          </ul>
          <h6><strong>Surgical &amp; Procedural Capacity</strong></h6>
          <ul>
            <li>Basic wound cleaning, dressing, injections, and minor outpatient treatment</li>
            <li>Urine testing, pregnancy testing, blood-glucose testing, ECG, and other basic assessments</li>
            <li>Minor procedures according to staff, equipment, and facility capability</li>
            <li>Stabilisation and referral for major trauma, acute surgical conditions, high-risk pregnancy, severe infection, and critical illness</li>
          </ul>
          <h6><strong>Diagnostic &amp; Support Infrastructure</strong></h6>
          <ul>
            <li>Consultation, treatment, observation, maternal-child, and vaccination areas</li>
            <li>Pharmacy or medicine-dispensing services at designated sites</li>
            <li>Phlebotomy and basic laboratory support at designated sites</li>
            <li>Dental, radiology, ultrasound, rehabilitation, and allied-health services at larger centres</li>
            <li>Electronic patient records and referral links with the wider Ministry of Health network</li>
          </ul>
          <h6><strong>Other Government Primary-Care Sites</strong></h6>
          <ul>
            <li>Brunei International Airport Health Clinic</li>
            <li>Prison medical clinics</li>
            <li>Al-Islah Centre Health Clinic</li>
            <li>Welfare House Complex health services</li>
            <li>School-health and institutional health services</li>
          </ul>
          <p><strong>Note:</strong> The primary-care network operates as the front line of the referral system. Service availability varies by site; patients should not assume that every health centre or health clinic provides the same diagnostic, dental, radiology, maternal, or allied-health services.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level55Modal" tabindex="-1" aria-labelledby="secondaryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center" style="gap:8px;">
          <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-blue.png" alt="" style="width:30px; height:30px;">
          <h5 class="modal-title" id="secondaryModalLabel">Secondary</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <ul class="nav nav-tabs px-3 pt-2" id="secondaryTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="secondary-overview-tab" data-bs-toggle="tab" data-bs-target="#secondary-overview" type="button" role="tab" aria-controls="secondary-overview" aria-selected="true">Overview</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="secondary-role-tab" data-bs-toggle="tab" data-bs-target="#secondary-role" type="button" role="tab" aria-controls="secondary-role" aria-selected="false">Role</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="secondary-clinical-tab" data-bs-toggle="tab" data-bs-target="#secondary-clinical" type="button" role="tab" aria-controls="secondary-clinical" aria-selected="false">Clinical Services</button>
        </li>
      </ul>
      <div class="modal-body tab-content">
        <div class="tab-pane fade show active" id="secondary-overview" role="tabpanel" aria-labelledby="secondary-overview-tab" tabindex="0">
          <p>Secondary hospitals provide district-level inpatient, emergency, maternity, surgical, medical, paediatric, and specialist services. They receive referrals from health centres and health clinics, manage cases requiring hospital admission, and refer highly complex patients to RIPAS Hospital or an appropriate specialist centre.</p>
          <p><strong>Note:</strong> Brunei maintains one government hospital in each district. RIPAS Hospital serves Brunei-Muara and the national tertiary role. Suri Seri Begawan Hospital serves Belait, Pengiran Muda Mahkota Pengiran Muda Haji Al-Muhtadee Billah Hospital serves Tutong, and Pengiran Isteri Hajjah Mariam Hospital serves Temburong.</p>
        </div>
        <div class="tab-pane fade" id="secondary-role" role="tabpanel" aria-labelledby="secondary-role-tab" tabindex="0">
          <ul>
            <li>Serve as the main hospital referral point for their respective districts</li>
            <li>Manage common and moderately complex inpatient, emergency, surgical, maternity, paediatric, and medical cases</li>
            <li>Provide specialist outpatient clinics directly or through visiting specialists</li>
            <li>Stabilise critical patients before transfer to a tertiary referral facility</li>
            <li>Support district-level radiology, laboratory, pharmacy, blood, dialysis, rehabilitation, and allied-health services</li>
            <li>Coordinate patient transfer with RIPAS Hospital and specialist centres</li>
          </ul>
        </div>
        <div class="tab-pane fade" id="secondary-clinical" role="tabpanel" aria-labelledby="secondary-clinical-tab" tabindex="0">
          <h6><strong>Bed Capacity</strong></h6>
          <ul>
            <li>No national bed-capacity band defines secondary classification</li>
            <li>Capacity varies by district population, infrastructure, ward configuration, and approved services</li>
            <li>Pengiran Muda Mahkota Pengiran Muda Haji Al-Muhtadee Billah Hospital is officially described as a 139-bedded hospital</li>
            <li>Suri Seri Begawan Hospital is the second-largest government hospital and operates as a district secondary-care hospital</li>
          </ul>
          <h6><strong>Main Facilities</strong></h6>
          <ul>
            <li>Suri Seri Begawan Hospital, Belait District</li>
            <li>Pengiran Muda Mahkota Pengiran Muda Haji Al-Muhtadee Billah Hospital, Tutong District</li>
            <li>Pengiran Isteri Hajjah Mariam Hospital, Temburong District</li>
          </ul>
          <h6><strong>Core Specialties</strong></h6>
          <ul>
            <li>General medicine and physician services</li>
            <li>General surgery</li>
            <li>Paediatrics</li>
            <li>Obstetrics and gynaecology</li>
            <li>Emergency medicine</li>
            <li>Orthopaedics, ophthalmology, ENT, dermatology, psychiatry, cardiology, and other visiting or resident specialist services according to facility capability</li>
          </ul>
          <h6><strong>Intermediate Services</strong></h6>
          <ul>
            <li>Twenty-four-hour emergency services</li>
            <li>Inpatient wards and outpatient clinics</li>
            <li>Maternity, postnatal, paediatric, medical, and surgical wards</li>
            <li>Intensive care or higher-acuity care where established</li>
            <li>Renal dialysis and rehabilitation services at designated hospitals</li>
            <li>Isolation facilities and infectious-disease support at designated sites</li>
          </ul>
          <h6><strong>Surgical &amp; Procedural Capacity</strong></h6>
          <ul>
            <li>General emergency and elective surgery within district-hospital capability</li>
            <li>Obstetric and gynaecological procedures</li>
            <li>Endoscopy, day surgery, ophthalmic procedures, and minor specialist procedures where available</li>
            <li>Anaesthesia, operating-theatre, recovery, and ward support</li>
            <li>Referral of complex cardiac, neurological, oncological, paediatric, reconstructive, and other tertiary cases</li>
          </ul>
          <h6><strong>Diagnostic &amp; Support Infrastructure</strong></h6>
          <ul>
            <li>General radiology and ultrasound, with additional modalities according to facility capability</li>
            <li>District laboratory services covering limited clinical chemistry, haematology, microbiology, blood-bank, and mortuary functions</li>
            <li>Pharmacy and phlebotomy services</li>
            <li>Physiotherapy, occupational therapy, dietetics, psychology, medical social work, and other allied-health services</li>
            <li>Ambulance, referral, and patient-transfer arrangements</li>
          </ul>
          <p><strong>Note:</strong> District hospitals do not operate as independent territorial health systems. They remain part of the Ministry of Health network and refer advanced cases into the national tertiary and specialist system.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level66Modal" tabindex="-1" aria-labelledby="tertiaryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center" style="gap:8px;">
          <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital-pin-red.png" alt="" style="width:30px; height:30px;">
          <h5 class="modal-title" id="tertiaryModalLabel">Tertiary</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <ul class="nav nav-tabs px-3 pt-2" id="tertiaryTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="tertiary-overview-tab" data-bs-toggle="tab" data-bs-target="#tertiary-overview" type="button" role="tab" aria-controls="tertiary-overview" aria-selected="true">Overview</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="tertiary-role-tab" data-bs-toggle="tab" data-bs-target="#tertiary-role" type="button" role="tab" aria-controls="tertiary-role" aria-selected="false">Role</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="tertiary-clinical-tab" data-bs-toggle="tab" data-bs-target="#tertiary-clinical" type="button" role="tab" aria-controls="tertiary-clinical" aria-selected="false">Clinical Services</button>
        </li>
      </ul>
      <div class="modal-body tab-content">
        <div class="tab-pane fade show active" id="tertiary-overview" role="tabpanel" aria-labelledby="tertiary-overview-tab" tabindex="0">
          <p>Tertiary referral facilities provide the highest level of complex hospital and specialist care available in Brunei Darussalam. They receive referrals from district hospitals, health centres, health clinics, private clinics, and specialist services. Raja Isteri Pengiran Anak Saleha Hospital is the main national tertiary referral hospital. Jerudong Park Medical Centre and Gleneagles JPMC provide major non-government specialist and tertiary services, including advanced cancer, neuroscience, rehabilitation, surgical, and cardiac care.</p>
          <p><strong>Note:</strong> Tertiary status in Brunei reflects national referral responsibility and advanced service capability. No published national rule assigns tertiary status through a fixed minimum bed threshold.</p>
        </div>
        <div class="tab-pane fade" id="tertiary-role" role="tabpanel" aria-labelledby="tertiary-role-tab" tabindex="0">
          <ul>
            <li>Serve as national referral centres for complex and severe cases</li>
            <li>Manage advanced medical, surgical, paediatric, obstetric, critical-care, and subspecialty conditions</li>
            <li>Provide definitive care after stabilisation or initial treatment at district hospitals and primary-care facilities</li>
            <li>Deliver advanced diagnostics, interventional procedures, intensive care, rehabilitation, and multidisciplinary treatment</li>
            <li>Support teaching, clinical training, specialist development, and national service planning</li>
            <li>Coordinate approved referrals to non-government or overseas providers when required</li>
          </ul>
        </div>
        <div class="tab-pane fade" id="tertiary-clinical" role="tabpanel" aria-labelledby="tertiary-clinical-tab" tabindex="0">
          <h6><strong>Bed Capacity</strong></h6>
          <ul>
            <li>No fixed national bed-capacity band defines tertiary facilities</li>
            <li>Capacity varies according to institutional role, specialty configuration, ward structure, and approved service expansion</li>
            <li>Specialist centres may operate as focused institutions without the bed profile of a full general hospital</li>
          </ul>
          <h6><strong>Main Facilities</strong></h6>
          <ul>
            <li>Raja Isteri Pengiran Anak Saleha Hospital (RIPAS Hospital) – main national tertiary referral hospital and major teaching hospital</li>
            <li>Jerudong Park Medical Centre (JPMC) – private specialist hospital providing 24-hour general, specialist, surgical, and hospital services</li>
            <li>Gleneagles JPMC – specialised tertiary cardiac centre</li>
            <li>The Brunei Cancer Centre and Brunei Neuroscience Stroke and Rehabilitation Centre – focused specialist services operating through the JPMC complex</li>
          </ul>
          <h6><strong>Core Specialties</strong></h6>
          <ul>
            <li>Internal medicine and medical subspecialties</li>
            <li>General surgery and surgical subspecialties</li>
            <li>Paediatrics and neonatal care</li>
            <li>Obstetrics and gynaecology</li>
            <li>Emergency medicine and critical care</li>
            <li>Cardiology and cardiac intervention</li>
            <li>Oncology and cancer treatment</li>
            <li>Neurology, neurosurgery, stroke care, and rehabilitation</li>
            <li>Renal medicine and dialysis</li>
            <li>Orthopaedics, urology, ophthalmology, ENT, plastic surgery, and oral and maxillofacial surgery</li>
          </ul>
          <h6><strong>Intermediate Services</strong></h6>
          <ul>
            <li>Twenty-four-hour emergency and inpatient services</li>
            <li>Specialist and subspecialist outpatient clinics</li>
            <li>Intensive care, high-dependency, neonatal, and paediatric critical-care services</li>
            <li>Pharmacy, blood services, allied health, medical social work, and rehabilitation</li>
            <li>Multidisciplinary case management and national referral coordination</li>
          </ul>
          <h6><strong>Surgical &amp; Procedural Capacity</strong></h6>
          <ul>
            <li>Major elective and emergency surgery</li>
            <li>Advanced anaesthesia and peri-operative care</li>
            <li>Complex paediatric, neurological, oncological, cardiac, reconstructive, orthopaedic, and other subspecialty procedures</li>
            <li>Interventional and minimally invasive procedures according to institutional capability</li>
            <li>Post-operative intensive care and multidisciplinary rehabilitation</li>
          </ul>
          <h6><strong>Diagnostic &amp; Support Infrastructure</strong></h6>
          <ul>
            <li>Advanced radiology, including CT, MRI, ultrasound, fluoroscopy, and specialised imaging</li>
            <li>Comprehensive laboratory, pathology, blood-bank, and reference testing support</li>
            <li>Critical-care monitoring and life-support systems</li>
            <li>Operating theatres, recovery areas, sterilisation services, and specialist procedural suites</li>
            <li>Pharmacy, physiotherapy, occupational therapy, speech therapy, dietetics, psychology, and social-work support</li>
          </ul>
          <p><strong>Note:</strong> RIPAS Hospital is the principal public tertiary referral institution. Non-government tertiary providers supplement national capacity through specialist treatment, direct private care, insurance or employer-funded care, and approved government referral arrangements.</p>
        </div>
      </div>
    </div>
  </div>
</div>

    <div style="position:relative;">

    <div id="map"></div>

    <!-- Route Detail Panel -->
    <div id="routePanel" style="
        display:none;
        position:absolute;
        top:10px;
        left:10px;
        width:300px;
        max-height:calc(100% - 20px);
        background:#fff;
        border-radius:10px;
        box-shadow:0 4px 20px rgba(0,0,0,0.18);
        z-index:999;
        flex-direction:column;
        overflow:hidden;
        font-family:inherit;
    ">
        <!-- Header -->
        <div style="background:#1a73e8;padding:12px 14px;color:#fff;display:flex;justify-content:space-between;align-items:center;flex-shrink:0;">
            <div>
                <div style="font-size:11px;opacity:0.85;letter-spacing:0.5px;">DRIVING DIRECTIONS</div>
                <div id="routePanelTitle" style="font-size:13px;font-weight:600;margin-top:2px;">—</div>
            </div>
            <button onclick="closeRoutePanel()" style="background:rgba(255,255,255,0.2);border:none;color:#fff;width:26px;height:26px;border-radius:50%;cursor:pointer;font-size:15px;line-height:1;display:flex;align-items:center;justify-content:center;">&times;</button>
        </div>
        <!-- Summary -->
        <div id="routeSummary" style="padding:10px 14px;background:#f0f4ff;border-bottom:1px solid #dde8ff;display:flex;gap:16px;flex-shrink:0;">
            <div style="text-align:center;">
                <div style="font-size:18px;font-weight:700;color:#1a73e8;" id="routeDistance">—</div>
                <div style="font-size:10px;color:#666;text-transform:uppercase;letter-spacing:0.4px;">Distance</div>
            </div>
            <div style="text-align:center;">
                <div style="font-size:18px;font-weight:700;color:#395272;" id="routeDuration">—</div>
                <div style="font-size:10px;color:#666;text-transform:uppercase;letter-spacing:0.4px;">Est. Time</div>
            </div>
        </div>
        <!-- Steps -->
        <div id="routeSteps" style="overflow-y:auto;flex:1;padding:8px 0;"></div>
    </div>

    </div>

</div>


@endsection

@push('service')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCd-WVlGgZFJwAtPZkbAEca2Np6OI7CBTM&libraries=places,geometry,drawing"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// === Inisialisasi Peta ===
const map = new google.maps.Map(document.getElementById('map'), {
    center: { lat: 4.50496989082565, lng: 114.63473217779837 },
    zoom: 9,
    mapTypeId: 'roadmap',
    mapTypeControl: true,
    fullscreenControl: true,
    streetViewControl: false
});

const infoWindow = new google.maps.InfoWindow();

// === Directions (in-map routing) ===
const directionsService  = new google.maps.DirectionsService();
const directionsRenderer = new google.maps.DirectionsRenderer({
    suppressMarkers: false,
    polylineOptions: { strokeColor: '#1a73e8', strokeWeight: 5, strokeOpacity: 0.85 }
});
directionsRenderer.setMap(map);

// "Clear Route" button
const clearRouteBtn = document.createElement('div');
clearRouteBtn.id = 'clearRouteBtn';
clearRouteBtn.innerHTML = '✕ Clear Route';
Object.assign(clearRouteBtn.style, {
    display: 'none',
    background: '#fff',
    border: '2px solid rgba(0,0,0,0.2)',
    borderRadius: '6px',
    padding: '6px 12px',
    fontSize: '13px',
    fontWeight: '600',
    cursor: 'pointer',
    margin: '10px',
    color: '#d32f2f',
    boxShadow: '0 2px 6px rgba(0,0,0,0.15)'
});
clearRouteBtn.title = 'Clear the current route';
clearRouteBtn.addEventListener('click', () => {
    directionsRenderer.setDirections({ routes: [] });
    clearRouteBtn.style.display = 'none';
    closeRoutePanel();
});
map.controls[google.maps.ControlPosition.TOP_CENTER].push(clearRouteBtn);

// Helper: close route panel
function closeRoutePanel() {
    const panel = document.getElementById('routePanel');
    if (panel) panel.style.display = 'none';
    directionsRenderer.setDirections({ routes: [] });
    clearRouteBtn.style.display = 'none';
}

// Helper: draw route on map + show panel
function showRouteOnMap(originLat, originLng, destLat, destLng, destName) {
    directionsService.route({
        origin: new google.maps.LatLng(originLat, originLng),
        destination: new google.maps.LatLng(destLat, destLng),
        travelMode: google.maps.TravelMode.DRIVING
    }, (result, status) => {
        if (status === 'OK') {
            directionsRenderer.setDirections(result);
            clearRouteBtn.style.display = 'inline-block';
            infoWindow.close();

            const leg = result.routes[0].legs[0];
            const panel = document.getElementById('routePanel');
            document.getElementById('routePanelTitle').textContent = destName || 'Destination';
            document.getElementById('routeDistance').textContent  = leg.distance.text;
            document.getElementById('routeDuration').textContent  = leg.duration.text;

            const stepsEl = document.getElementById('routeSteps');
            stepsEl.innerHTML = leg.steps.map((step, i) => {
                const raw = (step.html_instructions || step.instructions || '');
                const instruction = raw.replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').trim();
                if (!instruction) return '';
                const icons = {
                    'Turn left':        '↰',
                    'Turn right':       '↱',
                    'Keep left':        '↖',
                    'Keep right':       '↗',
                    'Continue':         '↑',
                    'Head':             '↑',
                    'Roundabout':       '↻',
                    'U-turn':           '⟳',
                    'Merge':            '↑',
                    'Ramp':             '↗',
                    'Destination':      '📍',
                };
                let icon = '•';
                for (const [key, val] of Object.entries(icons)) {
                    if (instruction.startsWith(key)) { icon = val; break; }
                }
                const isLast = i === leg.steps.length - 1;
                return `
                    <div style="display:flex;gap:10px;padding:8px 14px;
                                border-bottom:${isLast ? 'none' : '1px solid #f0f0f0'};
                                align-items:flex-start;">
                        <div style="min-width:22px;height:22px;background:${isLast ? '#395272' : '#e8f0fe'};
                                    border-radius:50%;display:flex;align-items:center;
                                    justify-content:center;font-size:12px;
                                    color:${isLast ? '#fff' : '#1a73e8'};flex-shrink:0;margin-top:1px;">
                            ${icon}
                        </div>
                        <div style="flex:1;">
                            <div style="font-size:12px;color:#222;line-height:1.4;">${instruction}</div>
                            <div style="font-size:11px;color:#888;margin-top:2px;">${step.distance.text}</div>
                        </div>
                    </div>`;
            }).join('');

            panel.style.display = 'flex';
        } else {
            if (status === 'ZERO_RESULTS') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Route Not Found',
                    text: 'No driving route could be found between your location and the destination. The two locations may not be connected by road.',
                    confirmButtonColor: '#1a73e8',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Directions Error',
                    text: 'Could not get directions: ' + status,
                    confirmButtonColor: '#1a73e8',
                    confirmButtonText: 'OK'
                });
            }
        }
    });
}

// --- Nearby Category Bar (Google Maps style) — Hotels only ---
let categoryMarkers   = [];
let activeCategoryBtn = null;

const categoryBar = document.createElement('div');
categoryBar.id = 'nearbyCategBar';
Object.assign(categoryBar.style, {
    display:       'none',
    background:    'transparent',
    padding:       '8px 10px 0',
    gap:           '8px',
    flexWrap:      'nowrap',
    overflowX:     'auto',
    maxWidth:      '90vw',
    scrollbarWidth:'none'
});

const nearbyCategories = [
    { label: 'Hotels', icon: '🏨', type: 'lodging' }
];

nearbyCategories.forEach(cat => {
    const btn = document.createElement('button');
    btn.textContent = cat.icon + ' ' + cat.label;
    Object.assign(btn.style, {
        display:      'inline-flex',
        alignItems:   'center',
        gap:          '4px',
        padding:      '6px 14px',
        borderRadius: '20px',
        border:       '1px solid rgba(0,0,0,0.12)',
        background:   '#fff',
        color:        '#222',
        fontSize:     '13px',
        fontWeight:   '500',
        cursor:       'pointer',
        whiteSpace:   'nowrap',
        boxShadow:    '0 1px 4px rgba(0,0,0,0.15)',
        transition:   'all 0.15s'
    });

    btn.addEventListener('click', () => {
        if (activeCategoryBtn === btn) {
            clearCategoryMarkers();
            resetCategoryBtn(btn);
            activeCategoryBtn = null;
            return;
        }
        if (activeCategoryBtn) resetCategoryBtn(activeCategoryBtn);
        activeCategoryBtn = btn;
        btn.style.background = '#1a73e8';
        btn.style.color      = '#fff';
        btn.style.borderColor= '#1a73e8';
        showNearbyCategory(cat.type, cat.label);
    });

    categoryBar.appendChild(btn);
});

map.controls[google.maps.ControlPosition.TOP_CENTER].push(categoryBar);

function resetCategoryBtn(btn) {
    btn.style.background  = '#fff';
    btn.style.color       = '#222';
    btn.style.borderColor = 'rgba(0,0,0,0.12)';
}

function clearCategoryMarkers() {
    categoryMarkers.forEach(m => m.setMap(null));
    categoryMarkers = [];
}

function showNearbyCategory(type, label) {
    if (!lastClickedLocation) return;
    clearCategoryMarkers();

    const center  = new google.maps.LatLng(lastClickedLocation.lat, lastClickedLocation.lng);
    const service = new google.maps.places.PlacesService(map);

    const iconColors = { lodging: '#1a73e8' };
    const color = iconColors[type] || '#555';

    function makeSvgIcon(col) {
        const svg = `<svg xmlns='http://www.w3.org/2000/svg' width='32' height='40' viewBox='0 0 32 40'>`
                  + `<path d='M16 0C7.16 0 0 7.16 0 16c0 12 16 24 16 24S32 28 32 16C32 7.16 24.84 0 16 0z' fill='${col}'/>`
                  + `<circle cx='16' cy='16' r='7' fill='#fff'/>`
                  + `</svg>`;
        return 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(svg);
    }

    service.nearbySearch({ location: center, radius: 5000, type }, (results, status) => {
        if (status !== google.maps.places.PlacesServiceStatus.OK) {
            if (status === 'ZERO_RESULTS') {
                alert(`No ${label.toLowerCase()} found within 5 km.`);
            } else {
                alert(`Failed to load ${label.toLowerCase()}. Error status: ${status}. Please ensure "Places API" is enabled and billing is active.`);
                console.error('PlacesService nearbySearch failed with status:', status);
            }
            return;
        }
        if (!results.length) return;

        results.forEach(place => {
            if (!place.geometry?.location) return;

            const marker = new google.maps.Marker({
                position: place.geometry.location,
                map,
                title: place.name,
                icon: { url: makeSvgIcon(color), scaledSize: new google.maps.Size(32, 40) },
                animation: google.maps.Animation.DROP
            });

            const dist     = google.maps.geometry.spherical.computeDistanceBetween(center, place.geometry.location);
            const distText = dist >= 1000 ? (dist / 1000).toFixed(1) + ' km' : Math.round(dist) + ' m';
            const rating   = place.rating ? `⭐ ${place.rating.toFixed(1)}` : '';
            const destLat  = place.geometry.location.lat();
            const destLng  = place.geometry.location.lng();
            const safeName = (place.name || '').replace(/'/g, "\\'");

            marker.addListener('click', () => {
                infoWindow.setContent(`
                    <div style="font-size:13px;min-width:190px;">
                        <h5 style="border-bottom:1px solid #ccc;margin:0 0 6px;font-size:14px;">${place.name}</h5>
                        <div style="color:#666;font-size:12px;margin-bottom:3px;">${label}</div>
                        ${rating  ? `<div style="font-size:12px;">${rating}</div>` : ''}
                        <div style="margin-top:4px;font-size:12px;color:#555;"> ${distText} from search location</div>
                        <div style="margin-top:8px;">
                            <button onclick="showRouteOnMap(${center.lat()},${center.lng()},${destLat},${destLng},'${safeName}')"
                                    style="display:inline-flex;align-items:center;gap:5px;
                                           background:#1a73e8;color:#fff;border:none;
                                           padding:5px 12px;border-radius:6px;font-size:12px;
                                           font-weight:500;cursor:pointer;">
                                <svg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                                    <polygon points='3 11 22 2 13 21 11 13 3 11'/>
                                </svg>
                                Get Directions
                            </button>
                        </div>
                    </div>`);
                infoWindow.open(map, marker);
            });

            categoryMarkers.push(marker);
        });
    });
}

// === Variabel Global ===
let hospitalMarkers = [];
let radiusCircle = null;
let radiusPinMarker = null;
let lastClickedLocation = null;
let drawnPolygonGeoJSON = null;

// === Polygon Draw (Custom Point-by-Point) ===
let isDrawingPolygon = false;
let polygonLatLngs = [];
let activePolygon = null;
let activePolyline = null;
let cursorPolyline = null;
let startMarker = null;

const drawButton = document.createElement('div');
drawButton.innerHTML = '⬟';
Object.assign(drawButton.style, {
    backgroundColor: 'white', border: '2px solid rgba(0,0,0,0.2)', borderRadius: '4px',
    width: '34px', height: '34px', textAlign: 'center', lineHeight: '30px',
    fontSize: '18px', cursor: 'pointer', margin: '10px'
});
drawButton.title = 'Draw Polygon (Click point by point, click starting point to finish)';
map.controls[google.maps.ControlPosition.LEFT_TOP].push(drawButton);

const clearButton = document.createElement('div');
clearButton.innerHTML = '🗑️';
Object.assign(clearButton.style, {
    backgroundColor: 'white', border: '2px solid rgba(0,0,0,0.2)', borderRadius: '4px',
    width: '34px', height: '34px', textAlign: 'center', lineHeight: '30px',
    fontSize: '16px', cursor: 'pointer', margin: '10px 0'
});
clearButton.title = 'Clear Polygon';
map.controls[google.maps.ControlPosition.LEFT_TOP].push(clearButton);

drawButton.addEventListener('click', () => {
    isDrawingPolygon = !isDrawingPolygon;
    if (isDrawingPolygon) {
        map.setOptions({ draggable: false });
        drawButton.style.backgroundColor = '#ccc';
        map.getDiv().style.cursor = 'crosshair';
        polygonLatLngs = [];
        if (activePolygon) activePolygon.setMap(null);
        if (activePolyline) activePolyline.setMap(null);
        if (cursorPolyline) cursorPolyline.setMap(null);
        if (startMarker) startMarker.setMap(null);
        activePolygon = null;
        activePolyline = new google.maps.Polyline({
            path: polygonLatLngs, strokeColor: '#ff6600', strokeOpacity: 0.8, strokeWeight: 3, clickable: false, map
        });
        cursorPolyline = new google.maps.Polyline({
            path: [], strokeColor: '#ff6600', strokeOpacity: 0.5, strokeWeight: 3, clickable: false, map
        });
        startMarker = null;
        drawnPolygonGeoJSON = null;
    } else {
        finishPolygon();
    }
});

map.addListener('mousemove', (e) => {
    if (!isDrawingPolygon || polygonLatLngs.length === 0) return;
    const lastPoint = polygonLatLngs[polygonLatLngs.length - 1];
    cursorPolyline.setPath([lastPoint, e.latLng]);
});

map.addListener('rightclick', () => {
    if (isDrawingPolygon) finishPolygon();
});

async function finishPolygon() {
    if (!isDrawingPolygon) return;
    isDrawingPolygon = false;
    map.setOptions({ draggable: true });
    drawButton.style.backgroundColor = 'white';
    map.getDiv().style.cursor = '';
    if (cursorPolyline) cursorPolyline.setMap(null);
    if (startMarker) startMarker.setMap(null);

    if (polygonLatLngs.length > 2) {
        if (activePolyline) activePolyline.setMap(null);
        activePolygon = new google.maps.Polygon({
            paths: polygonLatLngs, strokeColor: '#ff6600', strokeOpacity: 0.8, strokeWeight: 3,
            fillColor: '#ff6600', fillOpacity: 0.2, editable: true, map
        });

        const coordinates = polygonLatLngs.map(p => [p.lng(), p.lat()]);
        coordinates.push([polygonLatLngs[0].lng(), polygonLatLngs[0].lat()]);

        drawnPolygonGeoJSON = {
            type: "Feature",
            geometry: { type: "Polygon", coordinates: [coordinates] },
            properties: {}
        };

        const updatePolygonFilter = async () => {
            if (!activePolygon) return;
            const path = activePolygon.getPath();
            if (path.getLength() > 2) {
                const newCoords = [];
                for (let i = 0; i < path.getLength(); i++) {
                    const xy = path.getAt(i);
                    newCoords.push([xy.lng(), xy.lat()]);
                }
                newCoords.push([path.getAt(0).lng(), path.getAt(0).lat()]);
                drawnPolygonGeoJSON.geometry.coordinates = [newCoords];
                await applyHospitalFilters();
            }
        };

        google.maps.event.addListener(activePolygon.getPath(), 'set_at', updatePolygonFilter);
        google.maps.event.addListener(activePolygon.getPath(), 'insert_at', updatePolygonFilter);
        google.maps.event.addListener(activePolygon.getPath(), 'remove_at', updatePolygonFilter);

        await applyHospitalFilters();
    } else {
        if (activePolyline) activePolyline.setMap(null);
        activePolyline = null;
        activePolygon = null;
        drawnPolygonGeoJSON = null;
    }
}

clearButton.addEventListener('click', async () => {
    if (activePolygon) activePolygon.setMap(null);
    if (activePolyline) activePolyline.setMap(null);
    if (cursorPolyline) cursorPolyline.setMap(null);
    if (startMarker) startMarker.setMap(null);
    activePolygon = null;
    activePolyline = null;
    cursorPolyline = null;
    startMarker = null;
    polygonLatLngs = [];
    drawnPolygonGeoJSON = null;
    isDrawingPolygon = false;
    map.setOptions({ draggable: true });
    drawButton.style.backgroundColor = 'white';
    map.getDiv().style.cursor = '';
    await applyHospitalFilters();
});

// === Radius Circle & Location Pin ===
function updateRadiusCircleAndPin(radius = 0) {
    if (radiusCircle) { radiusCircle.setMap(null); radiusCircle = null; }

    if (radius > 0 && lastClickedLocation) {
        radiusCircle = new google.maps.Circle({
            strokeColor: '#FF0000', strokeOpacity: 0.8, strokeWeight: 2,
            fillColor: '#FF0000', fillOpacity: 0.2,
            map, center: lastClickedLocation, radius: radius * 1000
        });
    }
}

function placeLocationPin(location, label) {
    if (radiusPinMarker) { radiusPinMarker.setMap(null); radiusPinMarker = null; }
    radiusPinMarker = new google.maps.Marker({
        position: location,
        map,
        title: label || 'Selected Location',
        icon: {
            url: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            scaledSize: new google.maps.Size(25, 41)
        },
        zIndex: 9999,
        animation: google.maps.Animation.DROP
    });
}

map.addListener('click', e => {
    if (isDrawingPolygon) {
        polygonLatLngs.push(e.latLng);
        activePolyline.setPath(polygonLatLngs);

        if (polygonLatLngs.length === 1) {
            startMarker = new google.maps.Marker({
                position: e.latLng,
                map,
                icon: {
                    path: google.maps.SymbolPath.CIRCLE, scale: 6,
                    fillColor: '#FFFFFF', fillOpacity: 1, strokeColor: '#ff6600', strokeWeight: 2
                },
                zIndex: 999
            });
            startMarker.addListener('click', () => {
                if (isDrawingPolygon) finishPolygon();
            });
        }
        return;
    }

    lastClickedLocation = { lat: e.latLng.lat(), lng: e.latLng.lng() };
    placeLocationPin(lastClickedLocation, 'Selected Location');
    const radius = parseInt(document.querySelector('#radiusRangeMap')?.value || 0);
    const radiusValEl = document.querySelector('#radiusValueMap');
    if (radiusValEl) radiusValEl.textContent = radius;
    updateRadiusCircleAndPin(radius);
    categoryBar.style.display = 'flex';
    applyHospitalFilters();
});

// === Fetch Data Hospital ===
async function fetchHospitalData(filters = {}) {
    const params = new URLSearchParams();
    Object.entries(filters).forEach(([k, v]) => {
        if (Array.isArray(v)) v.forEach(x => params.append(`${k}[]`, x));
        else if (v !== '' && v != null) params.append(k, v);
    });
    if (drawnPolygonGeoJSON) params.append('polygon', JSON.stringify(drawnPolygonGeoJSON));

    try {
        const res = await fetch(`/api/hospital?${params.toString()}`);
        return res.ok ? await res.json() : [];
    } catch (e) {
        console.error('Error fetching hospital data:', e);
        return [];
    }
}

// === Tambah Marker Hospital ===
function addHospitalMarkers(data) {
    hospitalMarkers.forEach(m => m.setMap(null));
    hospitalMarkers = [];

    const bounds = new google.maps.LatLngBounds();

    data.forEach(h => {
        if (!h.latitude || !h.longitude) return;

        const position = { lat: parseFloat(h.latitude), lng: parseFloat(h.longitude) };

        const marker = new google.maps.Marker({
            position,
            map,
            icon: {
                url: h.icon || 'https://unpkg.com/leaflet/dist/images/marker-icon.png',
                scaledSize: new google.maps.Size(24, 24)
            }
        });

        const itemName  = h.name || 'N/A';
        const detailUrl = h.id ? `/hospitals/${h.id}` : '';

        const popupContent = `
            <h5 style="border-bottom:1px solid #ccc;">${h.name || 'N/A'}</h5>
            <strong>Global Classification:</strong> ${h.facility_category || 'N/A'}<br>
            <strong>Country Classification:</strong> ${h.facility_level || 'N/A'}<br>
            <strong>Address:</strong>
                ${h.address || 'N/A'}
                ${h.city ? ', ' + h.city : ''}
                ${h.provinces_region ? ', ' + h.provinces_region : ''}, Brunei Darussalam <br>
        `;

        marker.addListener('click', () => {
            const destLat = parseFloat(h.latitude);
            const destLng = parseFloat(h.longitude);

            const readMoreBtn = detailUrl ? `
                <a href="${detailUrl}"
                   style="display:inline-flex;align-items:center;gap:5px;
                          background:#395272;color:#fff;text-decoration:none;
                          padding:5px 12px;border-radius:6px;font-size:12px;
                          font-weight:500;"
                   onmouseover="this.style.background='#5686c3'"
                   onmouseout="this.style.background='#395272'">
                    <svg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                        <circle cx='12' cy='12' r='10'/><line x1='12' y1='8' x2='12' y2='12'/><line x1='12' y1='16' x2='12.01' y2='16'/>
                    </svg>
                    Read More
                </a>` : '';

            let actionButtons = '';
            if (lastClickedLocation && !isNaN(destLat) && !isNaN(destLng)) {
                const oLat = lastClickedLocation.lat;
                const oLng = lastClickedLocation.lng;
                actionButtons = `
                    <div style="margin-top:8px;padding-top:8px;border-top:1px solid #eee;display:flex;gap:6px;flex-wrap:wrap;">
                        <button onclick="showRouteOnMap(${oLat},${oLng},${destLat},${destLng},'${(itemName||'').replace(/'/g,"\\'")}')"
                           style="display:inline-flex;align-items:center;gap:5px;
                                  background:#1a73e8;color:#fff;border:none;
                                  padding:5px 12px;border-radius:6px;font-size:12px;
                                  font-weight:500;cursor:pointer;">
                            <svg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                                <polygon points='3 11 22 2 13 21 11 13 3 11'/>
                            </svg>
                            Get Directions
                        </button>
                        ${readMoreBtn}
                    </div>`;
            } else if (readMoreBtn) {
                actionButtons = `
                    <div style="margin-top:8px;padding-top:8px;border-top:1px solid #eee;">
                        ${readMoreBtn}
                    </div>`;
            }

            infoWindow.setContent(`<div style="font-size:13px; min-width: 200px;">${popupContent}${actionButtons}</div>`);
            infoWindow.open(map, marker);
        });

        hospitalMarkers.push(marker);
        bounds.extend(position);
    });

    if (hospitalMarkers.length > 0)
        map.fitBounds(bounds, 50);
}

// === Apply Filter ===
async function applyHospitalFilters() {
    const provs = [...document.querySelectorAll('.province-checkbox:checked')].map(e => e.value);
    const levels = [...document.querySelectorAll('input[name="hospitalLevel"]:checked')].map(e => e.value);
    const hospitalSelect = $('#hospital_name_map').val() || '';
    const hospitalName = Array.isArray(hospitalSelect) ? hospitalSelect[0] : hospitalSelect;
    const radius = parseInt(document.getElementById('radiusRangeMap')?.value || 0);

    let filters = {};
    if (hospitalName) filters.name = hospitalName;
    if (provs.length > 0) filters.provinces = provs;
    if (radius > 0 && lastClickedLocation) {
        filters.radius = radius;
        filters.center_lat = lastClickedLocation.lat;
        filters.center_lng = lastClickedLocation.lng;
    }

    const result = await fetchHospitalData(filters);

    // /api/hospital mengembalikan array polos.
    // Tetap toleran kalau suatu saat endpoint mengirim { hospitals, levelCounts }.
    const hospitals  = Array.isArray(result) ? result : (result.hospitals || []);
    const levelCounts = (!Array.isArray(result) && result.levelCounts) ? result.levelCounts : null;

    const filteredHospitals = hospitals.filter(h => {
        if (levels.length === 0) return true;
        if (!h.facility_level) return false;
        const dbLevels = h.facility_level.split(',').map(c => c.trim().toLowerCase());
        return levels.some(sel => dbLevels.includes(sel.toLowerCase()));
    });

    addHospitalMarkers(filteredHospitals);

    const totalEl = document.getElementById('totalCountDisplay');
    if (totalEl) {
        totalEl.innerHTML = `<strong>Hospitals:</strong> ${filteredHospitals.length}`;
    }

    // Pakai hitungan dari server kalau ada, kalau tidak hitung sendiri dari data.
    const counts = levelCounts || (() => {
        const local = {};
        hospitals.forEach(h => {
            if (!h.facility_level) return;
            h.facility_level.split(',').forEach(lvl => {
                lvl = lvl.trim();
                if (!lvl) return;
                local[lvl] = (local[lvl] || 0) + 1;
            });
        });
        return local;
    })();

    // Ambil level langsung dari checkbox yang ter-render, supaya daftarnya
    // tidak pernah beda dengan yang ada di panel filter.
    document.querySelectorAll('input[name="hospitalLevel"]').forEach(cb => {
        const badge = document.getElementById(`count-${cb.value.replace(/\s+/g, '-')}`);
        if (badge) badge.textContent = counts[cb.value] || 0;
    });
}

// === Filter Panel (Custom Google Maps Control) ===
const combinedPanelDiv = document.createElement('div');
combinedPanelDiv.id = 'combinedPanelDiv';
Object.assign(combinedPanelDiv.style, {
    background: 'white',
    borderRadius: '8px',
    boxShadow: '0 2px 6px rgba(0,0,0,0.2)',
    minWidth: '260px',
    maxWidth: '290px',
    overflow: 'visible',
    margin: '10px'
});

combinedPanelDiv.innerHTML = `
    <button style="background:#007bff;color:white;border:none;width:100%;padding:8px;border-radius:8px 8px 0 0;font-weight:600;letter-spacing:0.3px;">Filter &amp; Radius</button>

    <!-- Search Location - NOT inside scrollable div so dropdown is never clipped -->
    <div id="searchSection" style="padding:10px 10px 6px 10px;background:white;position:relative;">
        <strong style="font-size:12px;text-transform:uppercase;letter-spacing:0.5px;color:#555;">Search Location</strong>
        <div style="position:relative;margin-top:5px;">
            <input
                type="text"
                id="locationSearchMap"
                placeholder="Search Location..."
                autocomplete="off"
                style="width:100%;padding:7px 30px 7px 9px;border:1.5px solid #ddd;border-radius:6px;font-size:13px;box-sizing:border-box;"
            >
            <span id="locationSearchClear" title="Clear"
                style="position:absolute;right:8px;top:50%;transform:translateY(-50%);cursor:pointer;font-size:15px;color:#aaa;display:none;">&times;</span>
        </div>
        <div id="locationFoundBadge" style="display:none;margin-top:6px;background:#e8f5e9;border:1px solid #a5d6a7;border-radius:5px;padding:4px 8px;font-size:12px;color:#2e7d32;">
            &#128204; <span id="locationFoundName"></span>
        </div>
    </div>

    <!-- Radius -->
    <div id="radiusSection" style="padding:0 10px 0 10px;">
        <hr style="margin:8px 0;">
        <strong style="font-size:12px;text-transform:uppercase;letter-spacing:0.5px;color:#555;">Radius: <span id="radiusValueMap">0</span> km</strong>
        <input type="range" id="radiusRangeMap" min="0" max="500" value="0" style="width:100%;margin:4px 0;">
        <div style="display:flex;justify-content:space-between;font-size:11px;color:#888;margin-bottom:5px;">
            <span>0</span><span>250 km</span><span>500 km</span>
        </div>
        <div style="display:flex;gap:5px;margin-bottom:6px;">
            <button id="applyRadiusMap" class="btn btn-sm btn-primary flex-fill">Apply</button>
            <button id="resetRadiusMap" class="btn btn-sm btn-danger flex-fill">Reset</button>
        </div>
    </div>

    <!-- Scrollable filters -->
    <div id="filterPanel" style="padding:0 10px 10px 10px;max-height:52vh;overflow-y:auto;border-top:1px solid #eee;">
        <div style="padding-top:8px;">
            <label>Hospital Name:</label>
            <select id="hospital_name_map" class="form-select form-select-sm mb-2 select-search-hospital">
                <option value="">Select Hospital</option>
                @foreach($hospitalNames as $n)
                    <option value="{{ $n }}">{{ $n }}</option>
                @endforeach
            </select>
            <label>Facility Level:</label>
            ${['Tertiary','Secondary','Clinic / Health Center'].map(c => `
            <label style="display:block;font-size:13px;margin-bottom:5px;">
                <input type="checkbox" name="hospitalLevel" value="${c}">
                ${c} (<span id="count-${c.replace(/\s+/g,'-')}">0</span>)
            </label>
            `).join('')}
            <hr>
            <div class="filter-box" id="provinceSelect">
                <label class="filter-label">District</label>

                <div class="select-input">
                    <input
                        type="text"
                        id="provinceSearch"
                        placeholder="Select District"
                        readonly
                    >
                    <i class="bi bi-chevron-down"></i>
                </div>

                <div class="select-dropdown">
                    <input
                        type="text"
                        class="dropdown-search"
                        id="provinceSearchInput"
                        placeholder="Search District..."
                    >

                    <ul id="provinceList">
                        @foreach ($provinces as $p)
                        <li>
                            <label>
                                <input
                                    type="checkbox"
                                    class="province-checkbox"
                                    value="{{ $p->id }}"
                                >
                                {{ $p->provinces_region }}
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <hr>
            <button id="resetMapFilter" class="btn btn-sm btn-secondary w-100">Reset All</button>
            <div id="totalCountDisplay" style="margin-top:8px;text-align:center;font-size:13px;"></div>
        </div>
    </div>`;

google.maps.event.addDomListener(combinedPanelDiv, 'click', e => e.stopPropagation());
google.maps.event.addDomListener(combinedPanelDiv, 'dblclick', e => e.stopPropagation());
google.maps.event.addDomListener(combinedPanelDiv, 'mousedown', e => e.stopPropagation());
google.maps.event.addDomListener(combinedPanelDiv, 'touchstart', e => e.stopPropagation());
google.maps.event.addDomListener(combinedPanelDiv, 'wheel', e => e.stopPropagation());
map.controls[google.maps.ControlPosition.RIGHT_TOP].push(combinedPanelDiv);

// === Init Select2 (retry sampai panel benar-benar ada di DOM) ===
function initHospitalSelect2() {
    const el = document.getElementById('hospital_name_map');
    if (typeof $ === 'undefined' || !$.fn || !$.fn.select2 || !el) {
        setTimeout(initHospitalSelect2, 200);
        return;
    }
    if ($(el).hasClass('select2-hidden-accessible')) return;
    $(el).select2({
        width: '100%',
        placeholder: 'Search Hospital',
        allowClear: true
    });
}
initHospitalSelect2();

// Event select2 (delegated, jadi tidak tergantung timing DOM)
$(document).on('change', '#hospital_name_map', function() {
    applyHospitalFilters();
});

// === Init Location Search — Google Places Autocomplete ===
// .pac-container is repositioned to position:fixed via MutationObserver
// to bypass Google Maps container overflow:hidden clipping.
function initLocationSearch() {
    const input = document.getElementById('locationSearchMap');
    if (!input) {
        setTimeout(initLocationSearch, 300);
        return;
    }

    const clearBtn = document.getElementById('locationSearchClear');

    const autocomplete = new google.maps.places.Autocomplete(input, {
        types: ['geocode', 'establishment'],
        fields: ['geometry', 'name', 'formatted_address']
    });

    let pacContainer = null;

    function fixPacPosition() {
        if (!pacContainer) return;
        const rect = input.getBoundingClientRect();
        pacContainer.style.position   = 'fixed';
        pacContainer.style.zIndex     = '2147483647';
        pacContainer.style.top        = (rect.bottom + 2) + 'px';
        pacContainer.style.left       = rect.left + 'px';
        pacContainer.style.width      = rect.width + 'px';
        pacContainer.style.borderRadius = '0 0 8px 8px';
        pacContainer.style.boxShadow  = '0 8px 24px rgba(0,0,0,0.2)';
        pacContainer.style.fontFamily = 'inherit';
    }

    const observer = new MutationObserver(() => {
        if (!pacContainer) {
            pacContainer = document.querySelector('.pac-container');
            if (pacContainer) {
                fixPacPosition();
                new MutationObserver(fixPacPosition).observe(
                    pacContainer, { attributes: true, attributeFilter: ['style'] }
                );
            }
        }
    });
    observer.observe(document.body, { childList: true, subtree: false });

    window.addEventListener('scroll', fixPacPosition, true);
    window.addEventListener('resize', fixPacPosition);
    input.addEventListener('focus',  fixPacPosition);
    input.addEventListener('input',  fixPacPosition);

    google.maps.event.addDomListener(input, 'keydown',   e => e.stopPropagation());
    google.maps.event.addDomListener(input, 'mousedown', e => e.stopPropagation());

    input.addEventListener('focus', () => {
        input.style.borderColor = '#1a73e8';
        input.style.boxShadow   = '0 0 0 3px rgba(26,115,232,0.15)';
    });
    input.addEventListener('blur', () => {
        input.style.borderColor = '#ddd';
        input.style.boxShadow   = 'none';
    });

    input.addEventListener('input', () => {
        if (clearBtn) clearBtn.style.display = input.value.length ? 'inline' : 'none';
    });

    autocomplete.addListener('place_changed', () => {
        const place = autocomplete.getPlace();
        if (!place.geometry || !place.geometry.location) return;

        const loc = {
            lat: place.geometry.location.lat(),
            lng: place.geometry.location.lng()
        };
        lastClickedLocation = loc;

        map.panTo(loc);
        map.setZoom(12);

        const label = place.name || place.formatted_address || 'Location';
        placeLocationPin(loc, label);

        if (clearBtn) clearBtn.style.display = 'inline';

        const badge     = document.getElementById('locationFoundBadge');
        const badgeName = document.getElementById('locationFoundName');
        if (badge)     badge.style.display = 'block';
        if (badgeName) badgeName.textContent = label;

        const radius = parseInt(document.getElementById('radiusRangeMap')?.value || 0);
        updateRadiusCircleAndPin(radius);
        categoryBar.style.display = 'flex';
        applyHospitalFilters();
    });

    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            input.value = '';
            clearBtn.style.display = 'none';
            if (pacContainer) pacContainer.style.display = 'none';

            const badge = document.getElementById('locationFoundBadge');
            if (badge) badge.style.display = 'none';

            if (radiusPinMarker) { radiusPinMarker.setMap(null); radiusPinMarker = null; }
            if (radiusCircle)    { radiusCircle.setMap(null);    radiusCircle    = null; }
            lastClickedLocation = null;

            categoryBar.style.display = 'none';
            clearCategoryMarkers();
            if (activeCategoryBtn) { resetCategoryBtn(activeCategoryBtn); activeCategoryBtn = null; }

            const rEl    = document.getElementById('radiusRangeMap');
            const rValEl = document.getElementById('radiusValueMap');
            if (rEl)    rEl.value          = 0;
            if (rValEl) rValEl.textContent = '0';

            applyHospitalFilters();
            input.focus();
        });
    }
}

// === Events ===
document.addEventListener('input', e => {
    if (e.target.id === 'radiusRangeMap') {
        const r = parseInt(e.target.value || 0);
        document.getElementById('radiusValueMap').textContent = r;
        updateRadiusCircleAndPin(r);
    }
});

document.addEventListener('click', async e => {
    if (e.target.id === 'applyRadiusMap') {
        const radius = parseInt(document.getElementById('radiusRangeMap').value || 0);
        if (radius > 0 && !lastClickedLocation) {
            alert('Cari lokasi terlebih dahulu menggunakan kolom "Search Location", atau klik langsung pada peta untuk menentukan titik radius.');
            return;
        }
        await applyHospitalFilters();
    }

    if (e.target.id === 'resetRadiusMap') {
        document.getElementById('radiusRangeMap').value = 0;
        document.getElementById('radiusValueMap').textContent = '0';
        if (radiusCircle) { radiusCircle.setMap(null); radiusCircle = null; }
        if (radiusPinMarker) { radiusPinMarker.setMap(null); radiusPinMarker = null; }
        lastClickedLocation = null;

        const locInput = document.getElementById('locationSearchMap');
        const locClear = document.getElementById('locationSearchClear');
        const locBadge = document.getElementById('locationFoundBadge');
        if (locInput) locInput.value = '';
        if (locClear) locClear.style.display = 'none';
        if (locBadge) locBadge.style.display = 'none';

        categoryBar.style.display = 'none';
        clearCategoryMarkers();
        if (activeCategoryBtn) { resetCategoryBtn(activeCategoryBtn); activeCategoryBtn = null; }

        await applyHospitalFilters();
    }

    if (e.target.id === 'resetMapFilter') {
        document.querySelectorAll('#filterPanel input[type="checkbox"]').forEach(cb => cb.checked = false);
        if (typeof $ !== 'undefined' && $.fn && $.fn.select2) {
            $('.select-search-hospital').val(null).trigger('change');
        } else {
            document.getElementById('hospital_name_map').value = '';
        }

        const provinceSearch = document.getElementById('provinceSearch');
        if (provinceSearch) {
            provinceSearch.value = '';
            provinceSearch.placeholder = 'Select District';
        }
        const provinceSearchInput = document.getElementById('provinceSearchInput');
        if (provinceSearchInput) provinceSearchInput.value = '';
        document.querySelectorAll('#provinceList li').forEach(li => { li.style.display = ''; });
        const provinceDropdown = document.querySelector('#provinceSelect .select-dropdown');
        if (provinceDropdown) provinceDropdown.classList.remove('show');

        document.getElementById('radiusRangeMap').value = 0;
        document.getElementById('radiusValueMap').textContent = '0';
        if (radiusCircle) { radiusCircle.setMap(null); radiusCircle = null; }
        if (radiusPinMarker) { radiusPinMarker.setMap(null); radiusPinMarker = null; }
        lastClickedLocation = null;

        const locInput = document.getElementById('locationSearchMap');
        const locClear = document.getElementById('locationSearchClear');
        const locBadge = document.getElementById('locationFoundBadge');
        if (locInput) locInput.value = '';
        if (locClear) locClear.style.display = 'none';
        if (locBadge) locBadge.style.display = 'none';

        categoryBar.style.display = 'none';
        clearCategoryMarkers();
        if (activeCategoryBtn) { resetCategoryBtn(activeCategoryBtn); activeCategoryBtn = null; }

        closeRoutePanel();

        if (activePolygon) activePolygon.setMap(null);
        if (activePolyline) activePolyline.setMap(null);
        if (cursorPolyline) cursorPolyline.setMap(null);
        if (startMarker) startMarker.setMap(null);
        activePolygon = null;
        activePolyline = null;
        cursorPolyline = null;
        startMarker = null;
        polygonLatLngs = [];
        drawnPolygonGeoJSON = null;

        await applyHospitalFilters();
    }
}, true);

// === Checkbox & select change auto apply ===
document.addEventListener('change', e => {
    if (e.target.classList.contains('province-checkbox') || e.target.name === 'hospitalLevel') {
        applyHospitalFilters();
    }
});

// === District: Select - Search Checkbox ===
document.addEventListener('click', (e) => {
    const provinceSelectInput = e.target.closest('#provinceSelect .select-input');
    const provinceDropdown = document.querySelector('#provinceSelect .select-dropdown');

    if (provinceSelectInput) {
        if (provinceDropdown) provinceDropdown.classList.toggle('show');
    } else {
        const provinceSelect = document.getElementById('provinceSelect');
        if (provinceSelect && !provinceSelect.contains(e.target) && provinceDropdown) {
            provinceDropdown.classList.remove('show');
        }
    }
}, true);

document.addEventListener('keyup', (e) => {
    if (e.target.id === 'provinceSearchInput') {
        const keyword = e.target.value.toLowerCase();
        document.querySelectorAll('#provinceList li').forEach(li => {
            const text = li.textContent.toLowerCase();
            li.style.display = text.includes(keyword) ? '' : 'none';
        });
    }
});

document.addEventListener('change', function(e) {
    if (e.target.classList.contains('province-checkbox')) {
        const selected = [...document.querySelectorAll('.province-checkbox:checked')]
            .map(cb => cb.parentElement.textContent.trim());
        const provinceSearch = document.getElementById('provinceSearch');
        if (provinceSearch) {
            if (selected.length === 0) {
                provinceSearch.value = '';
                provinceSearch.placeholder = 'Select District';
            } else if (selected.length <= 2) {
                provinceSearch.value = selected.join(', ');
            } else {
                provinceSearch.value = selected.length + ' District Selected';
            }
        }
    }
});

// === Inisialisasi Awal ===
setTimeout(() => {
    initLocationSearch();
}, 350);

// Retry sampai panel filter benar-benar ter-attach ke DOM oleh Google Maps.
function initialApplyFilters() {
    if (!document.getElementById('totalCountDisplay')) {
        setTimeout(initialApplyFilters, 200);
        return;
    }
    applyHospitalFilters();
}
initialApplyFilters();
</script>

@endpush
