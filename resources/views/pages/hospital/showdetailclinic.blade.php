@extends('layouts.master')

@section('title','Detail Clinic')
@section('page-title', 'Papua New Guinea Medical Facility')

@push('styles')

<style>
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

    .clinical-service-table{

    }

    .clinical-service-table td{
        padding: 6px 0;
        border-bottom: 1px solid #dee2e6;
        border-top:none;
        line-height: 18px;
    }

    .card-header{
        padding: 0.25rem 1.25rem;
        color: #3c66b5;
        font-weight: bold;
    }

    .mb-4{
        margin-bottom: 0.5rem !important;
    }

    .clinical-service-table td{
        padding: 6px;
    }

    /* Classification */
    .classification {
      display: flex;
      width: 100%;
    }

    .class-column {
      flex: 1;
      text-align: center;

    }
    .class-column:last-child {
      border-right: none;
    }

    .class-header {
      font-weight: 600;
      padding: 0.1rem 0;
    }

    /* Color bars */
    .class-medical-classification {border: none; text-align: center;}
    .class-airport-category {border: none;}
    .class-advanced { border-bottom: 3px solid #0070c0; }
    .class-intermediate { border-bottom: 3px solid #00b050; }
    .class-basic { border-bottom: 3px solid #ffc000; }

    /* Hospital layout */
    .hospital-list {
      display: flex;
      flex-direction: column;
      align-items: center;

    }

    /* For side-by-side classes */
    .hospital-row {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 0;
    }

    .hospital-item {
      display: flex;
      align-items: center;
      gap: 0;
      font-size: 0.9rem;
      white-space: nowrap;
    }

    .hospital-icon {
      width: 18px;
      height: 18px;
      border-radius: 3px;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    /* Image inside icon box */
    .hospital-icon img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    /* Airfield icons */
    .category-item img {
      width: 16px;
      height: 16px;
      object-fit: contain;
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

     <div class="d-flex justify-content-between p-3" style="background-color: #dfeaf1;">
        <div class="d-flex flex-column gap-1">
            <h2 class="fw-bold mb-0">{{ $hospital->name }}</h2>
            <span class="fw-bold"><b>Global Classification:</b> {{ $hospital->facility_category }} | <b>Country Classification:</b> {{ $hospital->facility_level }}</span>
        </div>

        <div class="d-flex gap-2 ms-auto">

            <a href="{{ url('hospital') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('home') ? 'active' : '' }}">
                <i class="bi bi-house-door-fill fs-3"></i>
                <small>Home</small>
            </a>

            <!-- Button 2 -->
            <a href="{{ url('hospitals') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/'.$hospital->id) ? 'active' : '' }}">
                <img src="{{ asset('images/icon-menu-general-info.png') }}" style="width: 18px; height: 24px;">
                <small>General</small>
            </a>

            <!-- Button 3 -->
            <a href="{{ url('hospitals/clinic') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/clinic/'.$hospital->id) ? 'active' : '' }}">
                <img src="{{ asset('images/icon-menu-medical-facility-white.png') }}" style="width: 18px; height: 24px;">
                <small>Clinical</small>
            </a>

            <!-- Button 4 -->
            <a href="{{ url('hospitals/emergency') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/emergency/'.$hospital->id) ? 'active' : '' }}">
                <img src="{{ asset('images/icon-emergency-support-white.png') }}" style="width: 24px; height: 24px;">
                <small>Emergency</small>
            </a>

            <a href="{{ url('aircharter') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('aircharter') ? 'active' : '' }}">
                 <img src="{{ asset('images/icon-air-charter.png') }}" style="width: 48px; height: 24px;">
                <small>Air Charter</small>
            </a>

            <!-- Button 5 -->
            <a href="{{ url('airports') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports') ? 'active' : '' }}">
                <i class="bi bi-airplane fs-3"></i>
                <small>Aviation</small>
            </a>

            <a href="{{ url('police') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('police') ? 'active' : '' }}">
                <i class="bi bi-person-badge" style="width: 24px; height: 24px;"></i>
                <small>Police</small>
            </a>

            <!-- Button 7 -->
            <a href="{{ url('embassiees') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('embassiees') ? 'active' : '' }}">
            <img src="{{ asset('images/icon-embassy.png') }}" style="width: 24px; height: 24px;">
                <small>Embassies</small>
            </a>
        </div>
    </div>

     <div class="card mb-4 position-relative">
        <div class="card-body" style="padding:0 7px;">
            <small><i>Last Updated {{ $hospital->created_at->format('M Y') }}</i></small>

            @role('admin')
            <a href="{{ route('hospitaldata.edit', $hospital->id) }}"
            style="position:absolute; right:7px;" title="edit">
                <i class="fas fa-edit"></i>
            </a>
            @endrole
        </div>
    </div>

<div class="row">
    <div class="col-sm-4">
        <div class="card">
            <div class="classification" style="flex-direction: column; width:100%;">
                      <div class="class-header class-medical-classification">Medical Facility Classification</div>
                      <div class="classification">
                        <!-- Advanced -->
                        <div class="class-column">
                          <div class="class-header class-advanced">Advanced</div>
                          <div class="hospital-list">
                            <div class="hospital-item">
                              <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level66Modal">
                                <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital-pin-red.png" style="width:24px; height:24px;">
                                <small>Tertiary</small>
                              </button>
                            </div>
                          </div>
                        </div>

                        <!-- Intermediate -->
                        <div class="class-column">
                          <div class="class-header class-intermediate">Intermediate</div>
                          <div class="hospital-list">
                            <div class="hospital-row">
                              <div class="hospital-item">
                                <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level55Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-blue.png" style="width:24px; height:24px;">
                                  <small>Secondary</small>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Basic -->
                        <div class="class-column">
                          <div class="class-header class-basic">Basic</div>
                          <div class="hospital-list">
                            <div class="hospital-row">
                              <div class="hospital-item">
                                <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level11Modal">
                                    <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-tosca.png" style="width:24px; height:24px;">
                                    <small>Clinic / Health Center</small>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header fw-bold"><img src="{{ asset('images/icon-menu-medical-facility.png') }}" style="width: 24px; height: 24px;"> Clinical Services</div>
              <div class="card-body overflow-auto">
                <div class="row">
                <div class="col-sm-6">
                    <table class="table table-hover clinical-service-table">
                        <tr>
                            <td>Inpatient</td>
                            <td>{{ $hospital->inpatient_services }}</td>
                        </tr>
                        <tr>
                            <td>Outpatient</td>
                            <td>{{ $hospital->outpatient_services }}</td>
                        </tr>
                        <tr>
                            <td>24 hr ER</td>
                            <td>{{ $hospital->hour_emergency_services }}</td>
                        </tr>
                        <tr>
                            <td>Ambulance</td>
                            <td>{{ $hospital->ambulance }}</td>
                        </tr>
                        <tr>
                            <td>Helipad</td>
                            <td>{{ $hospital->helipad }}</td>
                        </tr>

                        @if (!empty($hospital->comments))
                        <tr>
                            <td>Note</td>
                            <td>{{ $hospital->comments }}</td>
                        </tr>
                        @endif

                        <tr>
                            <td>ICU</td>
                            <td>{{ $hospital->icu }}</td>
                        </tr>
                        <tr>
                            <td>Medical</td>
                            <td>{{ $hospital->medical }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-6">
                    <table class="table table-hover clinical-service-table">
                        <tr>
                            <td>Pediatric</td>
                            <td>{{ $hospital->pediatric }}</td>
                        </tr>
                        <tr>
                            <td>Dental</td>
                            <td>{{ $hospital->dental }}</td>
                        </tr>
                        <tr>
                            <td>Optical</td>
                            <td>{{ $hospital->optical }}</td>
                        </tr>
                        <tr>
                            <td>Integrated Outreach Clinic (IOC)</td>
                            <td>{{ $hospital->ioc }}</td>
                        </tr>
                        <tr>
                            <td>Laboratory</td>
                            <td>{{ $hospital->laboratory }}</td>
                        </tr>
                        <tr>
                            <td>Pharmacy</td>
                            <td>{{ $hospital->pharmacy }}</td>
                        </tr>
                        <tr>
                            <td>Medical Imaging</td>
                            <td>{{ $hospital->medical_imaging }}</td>
                        </tr>
                        <tr>
                            <td>Medical Student Training</td>
                            <td>{{ $hospital->medical_student_training }}</td>
                        </tr>
                    </table>
                </div>
                </div>
            </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                  <div class="card-header fw-bold"><img src="{{ asset('images/icon-medical-personel.png') }}" style="width: 32px; height: 24px;"> Medical Personnel</div>
             <div class="card-body overflow-auto">
                 <div class="row">
                <div class="col-sm-6">
                <table class="table table-hover clinical-service-table">
                    <tr>
                        <td>Doctors</td>
                        <td>{{ $hospital->doctors }}</td>
                    </tr>
                    <tr>
                        <td>Nurses</td>
                        <td>{{ $hospital->nurses }}</td>
                    </tr>
                    <tr>
                        <td>Dental Therapist</td>
                        <td>{{ $hospital->dental_therapist }}</td>
                    </tr>
                    <tr>
                        <td>Laboratory Assistants</td>
                        <td>{{ $hospital->laboratory_assistants }}</td>
                    </tr>
                    <tr>
                        <td>Community Health Workers/Orderlies</td>
                        <td>{{ $hospital->community_health }}</td>
                    </tr>
                </table>
                </div>
                <div class="col-sm-6">
                <table class="table table-hover clinical-service-table">
                    <tr>
                        <td>Health Inspectors</td>
                        <td>{{ $hospital->health_inspectors }}</td>
                    </tr>
                    <tr>
                        <td>Malaria Control Officers</td>
                        <td>{{ $hospital->malaria_control_officers ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Health Extension Officers</td>
                        <td>{{ $hospital->health_extention_officers }}</td>
                    </tr>
                    <tr>
                        <td>Casuals</td>
                        <td>{{ $hospital->casuals }}</td>
                    </tr>
                </table>
                </div>
                </div>
            </div>
            </div>

             <div class="card">
                <div class="card-body overflow-auto">
                    <div class="row">
                        <div class="col-sm-12">
                            <p>{!! $hospital->medical_personel_disclaimer; !!}</p>
                        </div>
                    </div>
                </div>
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

@endsection

@push('service')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
