<?php ?>
@if ($partName == 'basics')
    @if (isset($vcard))
        <input type="hidden" id="vcardId" value="{{ $vcard->id }}">
    @endif
    <div class="row" id="basic">
        <div class="col-lg-12 mb-7">
            {{ Form::label('url_alias', __('messages.vcard.url_alias') . ':', ['class' => 'form-label required']) }}
            <span data-bs-toggle="tooltip" data-placement="top"
                data-bs-original-title="{{ __('messages.tooltip.the_main_url') }}">
                <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
            </span>
            <div class="d-sm-flex">
                <div class="input-group">
                    {{ Form::text('url_alias', isset($vcard) ? $vcard->url_alias : null, ['class' => 'form-control ms-1 vcard-url-alias', 'id' => 'vcard-url-alias', 'placeholder' => __('messages.form.my_vcard_url')]) }}
                    <button class="btn btn-secondary" type="button" id="generate-url-alias"><i
                            class="fa-solid fa-arrows-rotate"></i></button>
                </div>
            </div>
            <div id="error-url-alias-msg" class="text-danger ms-2 fs-6 d-none fw-light">This URL Alias is already in use
            </div>
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('name', __('messages.vcard.vcard_name') . ':', ['class' => 'form-label required']) }}
            {{ Form::text('name', isset($vcard) ? $vcard->name : null, ['class' => 'form-control', 'placeholder' => __('messages.form.vcard_name'), 'required']) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('occupation', __('messages.vcard.occupation') . ':', ['class' => 'form-label']) }}
            {{ Form::text('occupation', isset($vcard) ? $vcard->occupation : null, ['class' => 'form-control', 'placeholder' => __('messages.form.occupation')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            <div class="mb-5">
                {{ Form::label('description', __('messages.vcard.description') . ':', ['class' => 'form-label']) }}
                <div id="vcardDescriptionQuill" class="editor-height" style="height: 200px"></div>
                {{ Form::hidden('description', isset($vcard) ? $vcard->description : null, ['id' => 'vcardDescriptionData']) }}
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-7">
            <div class="mb-3" io-image-input="true">
                <label for="exampleInputImage"
                    class="form-label">{{ __('messages.vcard.profile_image') . ':' }}</label>
                <div class="d-block">
                    <div class="image-picker">
                        <div class="image previewImage" id="exampleInputImage"
                            style="background-image: url('{{ !empty($vcard->profile_url) ? $vcard->profile_url : asset('web/media/avatars/user2.png') }}')">
                        </div>
                        <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                            data-placement="top" data-bs-original-title="{{ __('messages.tooltip.profile') }}">
                            <label>
                                <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                <input type="file" id="profile_image" name="profile_img"
                                    class="image-upload file-validation d-none" accept="image/*" />
                            </label>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-text">{{ __('messages.allowed_file_types') }}</div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-7">
            <div class="mb-3" io-image-input="true">
                <label for="exampleInputImage" class="form-label">{{ __('messages.vcard.cover_image') . ':' }}</label>
                <div class="d-block">
                    <div class="image-picker">
                        <div class="image previewImage" id="exampleInputImage"
                            style="background-image: url('{{ !empty($vcard->cover_url) ? $vcard->cover_url : asset('assets/images/default_cover_image.jpg') }}')">
                        </div>
                        <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                            data-placement="top" data-bs-original-title="{{ __('messages.tooltip.cover') }}">
                            <label>
                                <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                <input type="file" id="profile_image" name="cover_img"
                                    class="image-upload file-validation d-none" accept="image/*" />
                            </label>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-text">{{ __('messages.allowed_file_types') }}</div>
        </div>
        @if (isset($vcard))
            <div class="mt-5 row">
                <h4 class="fw-bolder text-gray-800 mb-5"> {{ __('messages.vcard.vcard_details') }} </h4>
                <div class="col-md-6">
                    <div class="form-group mb-7">
                        {{ Form::label('first_name', __('messages.vcard.first_name') . ':', ['class' => 'form-label required']) }}
                        {{ Form::text('first_name', isset($vcard) ? $vcard->first_name : null, ['class' => 'form-control', 'placeholder' => __('messages.form.f_name'), 'required']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-7">
                        {{ Form::label('last_name', __('messages.vcard.last_name') . ':', ['class' => 'form-label required']) }}
                        {{ Form::text('last_name', isset($vcard) ? $vcard->last_name : null, ['class' => 'form-control', 'placeholder' => __('messages.form.l_name'), 'required']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-7">
                        {{ Form::label('email', __('messages.user.email') . ':', ['class' => 'form-label']) }}
                        {{ Form::text('email', isset($vcard) ? $vcard->email : null, ['class' => 'form-control', 'placeholder' => __('messages.form.email')]) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('phone', __('messages.user.phone') . ':', ['class' => 'form-label']) }}
                        {{ Form::text('phone', isset($vcard) ? (isset($vcard->region_code) ? '+' . $vcard->region_code . '' . $vcard->phone : $vcard->phone) : null, ['class' => 'form-control', 'placeholder' => __('messages.form.phone'), 'id' => 'phoneNumber', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
                        {{ Form::hidden('region_code', isset($vcard) ? $vcard->region_code : null, ['id' => 'prefix_code']) }}
                        <div class="mt-2">
                            <span id="valid-msg"
                                class="text-success d-none fw-400 fs-small mt-2">{{ __('messages.placeholder.valid_number') }}</span>
                            <span id="error-msg" class="text-danger d-none fw-400 fs-small mt-2">Invalid Number</span>
                        </div>
                    </div>
                </div>
                <div class='col-md-6 col-lg-6 col-sm-6 col-12'>
                    <div class="form-group mb-7">
                        {{ Form::label('alternative_email', __('messages.vcard.alternate_email') . ':', ['class' => 'form-label']) }}
                        {{ Form::text('alternative_email', isset($vcard) ? $vcard->alternative_email : null, ['class' => 'form-control', 'placeholder' => __('messages.vcard.alternate_email')]) }}
                    </div>
                </div>
                <div class='col-md-6 col-lg-6 col-sm-6 col-12'>
                    <div class="form-group">
                        {{ Form::label('alternative_phone', __('messages.vcard.alternative_phone') . ':', ['class' => 'form-label']) }}
                        {{ Form::text('alternative_phone', isset($vcard) ? (isset($vcard->alternative_region_code) ? '+' . $vcard->alternative_region_code . '' . $vcard->alternative_phone : $vcard->alternative_phone) : null, ['class' => 'form-control', 'placeholder' => __('messages.vcard.alternative_phone'), 'id' => 'alternativePhone', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
                        {{ Form::hidden('alternative_region_code', isset($vcard) ? $vcard->alternative_region_code : null, ['id' => 'alternative_prefix_code']) }}
                        <div class="mt-2">
                            <span id="alter-valid-msg"
                                class="text-success d-none fw-400 fs-small mt-2">{{ __('messages.placeholder.valid_number') }}</span>
                            <span id="alter-error-msg" class="text-danger d-none fw-400 fs-small mt-2">Invalid
                                Number</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-7">
                        {{ Form::label('location', __('messages.user.location') . ':', ['class' => 'form-label']) }}
                        {{ Form::textarea('location', isset($vcard) ? $vcard->location : null, ['class' => 'form-control', 'placeholder' => __('messages.form.location'), 'rows' => '1']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-7">
                        {{ Form::label('location_url', __('messages.setting.location_url') . ':', ['class' => 'form-label']) }}
                        {{ Form::text('location_url', isset($vcard) ? $vcard->location_url : null, ['class' => 'form-control', 'placeholder' => __('messages.form.location_url')]) }}
                    </div>
                </div>
                <div class="col-lg-6 mb-7">
                    {{ Form::label('dob', __('messages.vcard.date_of_birth') . ':', ['class' => 'form-label']) }}
                    {{ Form::text('dob', isset($vcard) ? $vcard->dob : null, ['class' => 'form-control bg-white', 'placeholder' => __('messages.form.DOB')]) }}
                </div>
                <div class="col-lg-6 mb-7">
                    {{ Form::label('company', __('messages.vcard.company') . ':', ['class' => 'form-label']) }}
                    {{ Form::text('company', isset($vcard) ? $vcard->company : null, ['class' => 'form-control', 'placeholder' => __('messages.form.company')]) }}
                </div>
                @if (checkFeature('advanced'))
                    @if (checkFeature('advanced')->hide_branding)
                        <div class="col-lg-6 mb-7">
                            {{ Form::label('made_by', __('messages.made_by') . ':', ['class' => 'form-label']) }}
                            {{ Form::text('made_by', isset($vcard) ? $vcard->made_by : null, ['class' => 'form-control', 'placeholder' => __('messages.made_by')]) }}
                        </div>
                        <div class="col-lg-6 mb-7">
                            {{ Form::label('made_by_url', __('messages.made_by_url') . ':', ['class' => 'form-label']) }}
                            {{ Form::text('made_by_url', isset($vcard) ? $vcard->made_by_url : null, ['class' => 'form-control', 'placeholder' => __('messages.made_by_url')]) }}
                        </div>
                    @endif
                @endif
                <div class="col-lg-6 mb-7">
                    {{ Form::label('job_title', __('messages.vcard.job_title') . ':', ['class' => 'form-label']) }}
                    {{ Form::text('job_title', isset($vcard) ? $vcard->job_title : null, ['class' => 'form-control', 'placeholder' => __('messages.form.job')]) }}
                </div>
                <div class="col-lg-6 mb-7">
                    <div class="d-flex">
                        {{ Form::label('default_language', __('messages.setting.default_language') . ':', ['class' => 'form-label']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::select('default_language', getAllLanguage(), isset($vcard) ? (isset($vcard->default_language) ? $vcard->default_language : getCurrentLanguageName()) : null, ['class' => 'form-control', 'data-control' => 'select2']) }}
                    </div>
                </div>
                <div class="col-lg-6 mb-7">
                    <div class="d-flex">
                        {{ Form::label('language_enable', __('messages.vcard.language_enable') . ':', ['class' => 'form-label']) }}
                        <div class="mx-4">
                            <div
                                class="form-check form-switch form-check-custom form-check-solid form-switch-sm col-6">
                                <div class="fv-row d-flex align-items-center">
                                    {{ Form::checkbox('language_enable', 1, $vcard['language_enable'] ?? 0, ['class' => 'form-check-input mt-0 ', 'id' => 'languageEnable']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-7">
                    <div class="d-flex">
                        {{ Form::label('enable_enquiry_form', __('messages.vcard.enable_enquiry_form') . ':', ['class' => 'form-label']) }}
                        <div class="mx-4">
                            <div
                                class="form-check form-switch form-check-custom form-check-solid form-switch-sm col-6">
                                <div class="fv-row d-flex align-items-center">
                                    {{ Form::checkbox('enable_enquiry_form', 1, $vcard['enable_enquiry_form'] ?? 0, ['class' => 'form-check-input mt-0 ', 'id' => 'enableEnquiryForm']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-7">
                    <div class="d-flex">
                        {{ Form::label('enable_download_qr_code', __('messages.vcard.enable_download_qr_code') . ':', ['class' => 'form-label']) }}
                        <div class="mx-4">
                            <div
                                class="form-check form-switch form-check-custom form-check-solid form-switch-sm col-6">
                                <div class="fv-row d-flex align-items-center">
                                    {{ Form::checkbox('enable_download_qr_code', 1, $vcard['enable_download_qr_code'] ?? 0, ['class' => 'form-check-input mt-0 ', 'id' => 'enableDownloadQrCode']) }}
                                </div>
                            </div>
                        </div>
                    </div><br>
                    <div class="d-flex">
                        {{ Form::label('show_qr_code', __('messages.vcard.show_qr_code') . ':', ['class' => 'form-label']) }}
                        <div class="mx-3">
                            <div
                                class="form-check form-switch form-check-custom form-check-solid form-switch-sm col-6">
                                <div class="fv-row d-flex align-items-center">
                                    {{ Form::checkbox('show_qr_code', 1, $vcard['show_qr_code'] ?? 0, ['class' => 'form-check-input mt-0 ', 'id' => 'enableQrCode']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-7">
                    <label for="qrCodeDownloadSize"
                        class="form-label">{{ __('messages.vcard.qr_code_download_size') . ':' }}</label>
                    <div class="d-flex align-items-center">
                        <input type="range" name="qr_code_download_size" class="form-range w-50 mx-2"
                            value="{{ $vcard['qr_code_download_size'] }}" min="100" max="500"
                            step="100" id="qrCodeDownloadSize"
                            oninput="document.getElementById('download-result').innerText = this.value+'px'"> <span
                            id="download-result">{{ $vcard['qr_code_download_size'] . 'px' }}</span>
                    </div>
                </div>
            </div>
        @endif
        <div class="d-flex">
            {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3', 'id' => 'vcardSaveBtn']) }}
            <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
    </div>
@endif

@if ($partName == 'templates')
    <div class="col-lg-12 mb-3">
        <input type="hidden" name="part" value="{{ $partName }}">
        <label class="form-label required">{{ __('messages.vcard.select_template') }}
            :</label>
    </div>
    <div class="form-group mb-7 vcard-template">
        <div class="row">
            <input type="hidden" name="template_id" id="templateId" value="{{ $vcard->template_id }}">
            @foreach ($templates as $id => $url)
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-3 templatecard">
                    <div class="img-radio img-thumbnail {{ $id == 11 ? 'screen vcard_11' : '' }} {{ $vcard->template_id == $id ? 'img-border' : '' }} @if($id == 22) ribbon @endif"
                        data-id="{{ $id }}">
                        <img src="{{ $url }}" alt="Template">
                        @if($id == 22)
                        <div class="ribbon-wrapper">
                            <div class="ribbon fw-bold">{{ __('messages.feature.dynamic_vcard') }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-lg-12 mt-5 mb-5">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="vcardTemplateStatus" name="status"
                {{ $vcard->status ? 'checked' : '' }}>
            <label class="form-check-label" for="vcardTemplateStatus">
                {{ __('messages.common.active') }}
            </label>
        </div>
    </div>
    <div class="col-lg-12 mt-2 d-flex">
        <button class="btn btn-primary me-3 template-save">
            {{ __('messages.common.save') }}
        </button>
        <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
    </div>
@endif

@if ($partName === 'business-hours')
    <div class="row">
        <input type="hidden" name="part" value="{{ $partName }}">
        @foreach (\App\Models\BusinessHour::DAY_OF_WEEK as $key => $day)
            <div class="col-xxl-6 mb-7 d-sm-flex align-items-center mb-3">
                <div class="col-xl-4 col-lg-4 col-md-2 col-4">
                    <label class="form-check">
                        <input class="form-check-input feature mx-2" type="checkbox" value="{{ $key }}"
                            name="days[]" {{ !empty($hours[$key]) ? 'checked' : '' }} />
                        {{ strtoupper(__('messages.business.' . $day)) }}
                    </label>
                </div>
                <div class="col-xl-8 col-lg-3 col-3 d-flex align-items-center buisness_end">
                    <div class="d-inline-block">
                        {{ Form::select('startTime[' . $key . ']', getSchedulesTimingSlot(), isset($hours[$key]) ? $hours[$key]['start_time'] : null, ['class' => 'form-control', 'data-control' => 'select2']) }}
                    </div>
                    <span class="px-3">To</span>
                    <div class="d-inline-block">
                        {{ Form::select('endTime[' . $key . ']', getSchedulesTimingSlot(), isset($hours[$key]) ? $hours[$key]['end_time'] : null, ['class' => 'form-control', 'data-control' => 'select2']) }}
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-lg-12 mt-2 d-flex">
            <button class="btn btn-primary me-3">
                {{ __('messages.common.save') }}
            </button>
            <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
@endif

@if ($partName == 'appointments')
    <div class="col-12">
        <table class="table table-striped mt-lg-4">
            <tbody>
                <input type="hidden" name="part" value="{{ $partName }}">
                @foreach (App\Models\BusinessHour::WEEKDAY_NAME as $day => $shortWeekDay)
                    <tr>
                        <td>
                            <div class="weekly-content" data-day="{{ $day }}">
                                <div class="d-flex w-100 align-items-center position-relative">
                                    <div class="d-flex row flex-md-row flex-column w-100 weekly-row">
                                        <div class="col-xl-2 form-check mb-0 d-flex align-items-center ms-5">
                                            <input id="chkShortWeekDay_{{ $shortWeekDay }}" class="form-check-input"
                                                type="checkbox" value="{{ $day }}"
                                                name="checked_week_days[]" {{ !empty($time[$day]) ? 'checked' : '' }}>
                                            <label class="form-label mb-0 me-2"
                                                for="chkShortWeekDay_{{ $shortWeekDay }}">
                                                <span
                                                    class="ms-4 d-md-block">{{ strtoupper(__('messages.business.' . strtolower($shortWeekDay))) }}</span>
                                            </label>
                                        </div>
                                        <div class="col-xl-8 session-times">
                                            @include('vcards.appointment.slot', ['day' => $day])
                                        </div>
                                    </div>
                                    <div class="weekly-icon position-absolute end-0 d-flex">
                                        <a href="javascript:void(0)" class="add-session-time"
                                            id="add-session-{{ $day }}" data-day="{{ $day }}"
                                            data-bs-toggle="tooltip" title="{{ __('messages.common.add') }}">
                                            <i class="fa fa-plus text-primary me-5 fs-2 mb-3" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p class="ms-1 fw-bold">{{ __('messages.appointment.appointment_type') }}</p>
        <div class="weekly-icon end-0 d-flex py-4 px-0 ">
            @if (isset($appointmentDetail->is_paid))
                <button type="button"
                    class="btn me-3 {{ $appointmentDetail->is_paid == 0 ? 'btn-primary' : 'btn-light btn-active-light-primary' }}"
                    id="freeButton">{{ __('messages.appointment.free') }}</button>
                <button type="button"
                    class="btn me-3 {{ $appointmentDetail->is_paid == 1 ? 'btn-primary' : 'btn-light btn-active-light-primary' }}"
                    id="paidButton">{{ __('messages.appointment.paid') }}</button>
                <input type="hidden" id="isUserPaidId" name="is_paid" value="{{ $appointmentDetail->is_paid }}">
            @else
                <button type="button" class="btn me-3 btn-primary"
                    id="freeButton">{{ __('messages.appointment.free') }}</button>
                <button type="button" class="btn me-3 btn-light btn-active-light-primary"
                    id="paidButton">{{ __('messages.appointment.paid') }}</button>
                <input type="hidden" id="isUserPaidId" name="is_paid" value="0">
            @endif
        </div>
        <div class="card-body px-0 pt-0">
            <div class="row {{ isset($appointmentDetail->is_paid) && $appointmentDetail->is_paid == 1 ? '' : 'd-none' }}"
                id="userPaidInputDiv">
                <div class="col-12">
                    <div class="row">
                        <div class="form-group col-sm-6 px-3">
                            {{ Form::label('price', __('messages.subscription.amount') . ':', ['class' => 'form-label required']) }}
                            @if (isset($appointmentDetail))
                                {{ Form::number('price', $appointmentDetail->price, ['class' => 'form-control', $appointmentDetail->is_paid == 1 ? 'required' : '', 'id' => 'userPaymentAmount', 'placeholder' => __('messages.subscription.amount'), 'min' => '0']) }}
                            @else
                                {{ Form::number('price', null, ['class' => 'form-control', 'id' => 'userPaymentAmount', 'placeholder' => __('Amount'), 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")', 'min' => '0']) }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 d-flex">
            <button type="submit" class="btn btn-primary me-3">
                {{ __('messages.common.save') }}
            </button>
            <a href="{{ route('vcards.index') }}"
                class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
    </div>
@endif

@if ($partName == 'social-links')
    <p>{{ __('messages.setting.note') }}</p>
    <input type="hidden" name="part" value="{{ $partName }}">
    <div class="row social-links-add">
        <div class="col-12 mb-7 d-flex justify-content-end">
            <button type="button" class="btn btn-primary social-links">{{ __('messages.common.add') }}</button>
        </div>
        <div class="col-lg-6 mb-7">
            <div class="row">
                <div class="col-sm-1 mb-3 mb-sm-0">
                    <i class="fas fa-globe fa-2x text-primary mt-3 me-3"></i>
                </div>
                <div class="col-sm-11">
                    {!! Form::text('website', isset($socialLink) ? $socialLink->website : null, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.form.website'),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-7">
            <div class="row">
                <div class="col-sm-1 mb-sm-0 p-2 px-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#000" viewBox="0 0 448 512" width="30"
                            height="30">
                            <path
                                d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm297.1 84L257.3 234.6 379.4 396H283.8L209 298.1 123.3 396H75.8l111-126.9L69.7 116h98l67.7 89.5L313.6 116h47.5zM323.3 367.6L153.4 142.9H125.1L296.9 367.6h26.3z" />
                        </svg>
                </div>
                <div class="col-sm-11">
                    {!! Form::text('twitter', isset($socialLink) ? $socialLink->twitter : null, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.form.twitter'),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-7">
            <div class="row">
                <div class="col-sm-1 mb-3 mb-sm-0">
                    <i class="fab fa-facebook-square fa-2x text-primary mt-3 me-3"></i>
                </div>
                <div class="col-sm-11">
                    {!! Form::text('facebook', isset($socialLink) ? $socialLink->facebook : null, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.form.facebook'),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-7">
            <div class="row">
                <div class="col-sm-1 mb-3 mb-sm-0">
                    <i class="fab fa-instagram fa-2x text-danger mt-3 me-3"></i>
                </div>
                <div class="col-sm-11">
                    {!! Form::text('instagram', isset($socialLink) ? $socialLink->instagram : null, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.form.instagram'),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-7">
            <div class="row">
                <div class="col-sm-1 mb-3 mb-sm-0">
                    <i class="fab fa-reddit-alien fa-2x text-danger mt-3 me-3"></i>
                </div>
                <div class="col-sm-11">
                    {!! Form::text('reddit', isset($socialLink) ? $socialLink->reddit : null, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.form.reddit'),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-7">
            <div class="row">
                <div class="col-sm-1 mb-3 mb-sm-0">
                    <i class="fab fa-tumblr-square fa-2x text-dark mt-3 me-3"></i>
                </div>
                <div class="col-sm-11">
                    {!! Form::text('tumblr', isset($socialLink) ? $socialLink->tumblr : null, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.form.tumblr'),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-7">
            <div class="row">
                <div class="col-sm-1 mb-3 mb-sm-0">
                    <i class="fab fa-youtube fa-2x text-danger mt-3 me-3"></i>
                </div>
                <div class="col-sm-11">
                    {!! Form::text('youtube', isset($socialLink) ? $socialLink->youtube : null, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.form.youtube'),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-7">
            <div class="row">
                <div class="col-sm-1 mb-3 mb-sm-0">
                    <i class="fab fa-linkedin fa-2x text-primary mt-3 me-3"></i>
                </div>
                <div class="col-sm-11">
                    {!! Form::text('linkedin', isset($socialLink->linkedin) ? $socialLink->linkedin : null, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.form.linkedin'),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-7">
            <div class="row">
                <div class="col-sm-1 mb-3 mb-sm-0">
                    <i class="fab fa-whatsapp fa-2x text-success mt-3 me-3"></i>
                </div>
                <div class="col-sm-11">
                    {!! Form::text('whatsapp', isset($socialLink) ? $socialLink->whatsapp : null, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.form.whatsapp'),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-7">
            <div class="row">
                <div class="col-sm-1 mb-3 mb-sm-0">
                    <i class="fab fa-pinterest fa-2x text-danger mt-3 me-3"></i>
                </div>
                <div class="col-sm-11">
                    {!! Form::text('pinterest', isset($socialLink) ? $socialLink->pinterest : null, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.form.pinterest'),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-7">
            <div class="row">
                <div class="col-sm-1 mb-3 mb-sm-0">
                    <i class="fab fa-tiktok fa-2x text-danger mt-3 me-3"></i>
                </div>
                <div class="col-sm-11">
                    {!! Form::text('tiktok', isset($socialLink) ? $socialLink->tiktok : null, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.form.tiktok'),
                    ]) !!}
                </div>
            </div>
        </div>

        @foreach ($socialLink->icon as $key => $link)
            <div class="col-lg-6 mb-7 social-links-div">
                <div class="d-flex">
                    <div class="mb-3 mb-sm-0 me-3">
                        <div class="" io-image-input="true">
                            <div class="    ">
                                <div class="image-picker">
                                    <div class="image previewImage " id="exampleInputImage"
                                        style="background-image: url('{!! $link->social_icon ?? 'https://cdn-icons-png.flaticon.com/512/87/87390.png' !!} ') ;width: 40px; height: 40px">
                                    </div>
                                    <span class="picker-edit rounded-circle text-gray-500 fs-small"
                                        data-bs-toggle="tooltip" data-placement="top"
                                        data-bs-original-title="{{ __('messages.tooltip.profile') }}"
                                        style="width: 22px; height: 22px">
                                        <label>
                                            <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                            <input type="file" id="profile_image"
                                                name="social_links_image[{{ $key }}]"
                                                class="image-upload file-validation d-none social_links_image"
                                                accept="image/*" value="{{ $link->social_icon }}" />
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex ml-2 w-100">
                        <input type="text" class="form-control social_links"
                            name="social_links[{{ $key }}]" value="{{ $link->link }}">
                        <input type="hidden" name="social_link_id[{{ $key }}]" class="socialLinkId"
                            value="{{ $link->id }}">
                        <a href="javascript:void(0)" title="{{ __('messages.common.delete') }}"
                            class="btn px-1 text-danger fs-3 social-links-delete-btn">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="col-lg-12 d-flex">
        <button type="button" class="btn btn-primary me-3 social_link_save">
            {{ __('messages.common.save') }}
        </button>
        <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
    </div>

@endif

@if ($partName == 'advanced')
    <div class="row">
        <input type="hidden" name="part" value="{{ $partName }}">
        @if (checkFeature('advanced')->password)
            <div class="col-lg-6 mb-7">
                <label class="form-label">{{ __('messages.user.password') . ':' }}</label>
                <div class="position-relative mb-3">
                    <div class="mb-3 position-relative">
                        <input class="form-control" type="password"
                            placeholder="{{ __('messages.form.password') }}" name="password"
                            value="{{ !empty($vcard->password) ? Crypt::decrypt($vcard->password) : '' }}"
                            autocomplete="off" aria-label="Password" data-toggle="password" />
                        <span
                            class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600">
                            <i class="bi bi-eye-slash-fill"></i>
                        </span>
                    </div>
                    <div class="d-flex align-items-center mb-3"></div>
                </div>
            </div>
        @endif

        @if (checkFeature('advanced')->custom_css)
            <div class="col-lg-12 mb-7">
                {{ Form::label('custom_css', __('messages.vcard.custom_css') . ':', ['class' => 'form-label']) }}
                {{ Form::textarea('custom_css', isset($vcard) ? $vcard->custom_css : null, ['class' => 'form-control', 'placeholder' => __('messages.form.css'), 'rows' => '5']) }}
            </div>
        @endif

        @if (checkFeature('advanced')->custom_js)
            <div class="col-lg-12 mb-7">
                {{ Form::label('custom_js', __('messages.vcard.custom_js') . ':', ['class' => 'form-label']) }}
                {{ Form::textarea('custom_js', isset($vcard) ? $vcard->custom_js : null, ['class' => 'form-control', 'placeholder' => __('messages.form.js'), 'rows' => '5']) }}
            </div>
        @endif

        @if (checkFeature('advanced')->hide_branding)
            <div class="col-lg-6 mb-7">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="branding" name="branding"
                        {{ $vcard->branding ? 'checked' : '' }}>
                    <label class="form-label" for="branding">
                        {{ __('messages.vcard.remove_branding') }}
                    </label>
                    <span data-bs-toggle="tooltip" data-placement="top"
                        data-bs-original-title="{{ __('messages.tooltip.remove_branding') }}">
                        <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
                    </span>
                </div>
            </div>
        @endif

        <div class="col-lg-12 d-flex">
            <button type="submit" class="btn btn-primary me-3">
                {{ __('messages.common.save') }}
            </button>
            <a href="{{ route('vcards.index') }}"
                class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
    </div>
@endif

@if ($partName == 'custom-fonts')
    <div class="row">
        <div class="col-lg-6 mb-7">
            {{ Form::label('font_family', __('messages.font.font_family') . ':', ['class' => 'form-label']) }}
            {{ Form::select(
                'font_family',
                \App\Models\Vcard::FONT_FAMILY,
                \App\Models\Vcard::FONT_FAMILY[$vcard->font_family],
                ['class' => 'form-select', 'data-control' => 'select2'],
            ) }}
        </div>
        <div class="col-lg-6 mb-7">
            {!! Form::label('font_size', __('messages.font.font_size') . ':', ['class' => 'form-label']) !!}

            {!! Form::number('font_size', $vcard->font_size, [
                'class' => 'form-control',
                'min' => '14',
                'max' => '40',
                'placeholder' => __('messages.font.font_size_in_px'),
            ]) !!}
        </div>
        <div class="col-lg-12 d-flex">
            <button type="submit" class="btn btn-primary me-3">
                {{ __('messages.common.save') }}
            </button>
            <a href="{{ route('vcards.index') }}"
                class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
@endif

@if ($partName == 'seo')
    <div class="row">
        <div class="col-lg-6 mb-7">
            {{ Form::label('Site title', __('messages.vcard.site_title') . ':', ['class' => 'form-label']) }}
            {{ Form::text('site_title', isset($vcard) ? $vcard->site_title : null, ['class' => 'form-control', 'placeholder' => __('messages.form.site_title')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Home title', __('messages.vcard.home_title') . ':', ['class' => 'form-label']) }}
            {{ Form::text('home_title', isset($vcard) ? $vcard->home_title : null, ['class' => 'form-control', 'placeholder' => __('messages.form.home_title')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Meta keyword', __('messages.vcard.meta_keyword') . ':', ['class' => 'form-label']) }}
            {{ Form::text('meta_keyword', isset($vcard) ? $vcard->meta_keyword : null, ['class' => 'form-control', 'placeholder' => __('messages.form.meta_keyword')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Meta Description', __('messages.vcard.meta_description') . ':', ['class' => 'form-label']) }}
            {{ Form::text('meta_description', isset($vcard) ? $vcard->meta_description : null, ['class' => 'form-control', 'placeholder' => __('messages.form.meta_description')]) }}
        </div>
        <div class="col-lg-12 mb-7">
            {{ Form::label('Google Analytics', __('messages.vcard.google_analytics') . ':', ['class' => 'form-label']) }}
            {{ Form::textarea('google_analytics', isset($vcard) ? $vcard->google_analytics : null, ['class' => 'form-control', 'placeholder' => __('messages.form.google_analytics')]) }}
        </div>
        <div class="col-lg-12 d-flex">
            <button type="submit" class="btn btn-primary me-3">
                {{ __('messages.common.save') }}
            </button>
            <a href="{{ route('vcards.index') }}"
                class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
@endif

@if ($partName == 'privacy-policy')
    <div class="row">
        <div class="col-lg-12">
            <div class="mb-5">
                <input type="hidden" name="part" value="{{ $partName }}" id="privacyPolicyPartName">
                {{ Form::hidden('id', isset($privacyPolicy) ? $privacyPolicy->id : null, ['id' => 'privacyPolicyId']) }}
                {{ Form::label('privacy_policy', __('messages.vcard.privacy_policy') . ':', ['class' => 'form-label required']) }}
                <div id="privacyPolicyQuill" class="editor-height" style="height: 200px"></div>
                {{ Form::hidden('privacy_policy', isset($privacyPolicy) ? $privacyPolicy->privacy_policy : null, ['id' => 'privacyData']) }}
            </div>
        </div>
        <div class="col-lg-12 d-flex">
            <button type="submit" class="btn btn-primary me-3" id="privacyPolicySave">
                {{ __('messages.common.save') }}
            </button>
            <a href="{{ route('vcards.index') }}"
                class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
    </div>
@endif

@if ($partName == 'term-condition')
    <div class="row">
        <input type="hidden" name="part" value="{{ $partName }}" id="termConditionPartName">
        <div class="col-lg-12">
            <div class="mb-5">
                {{ Form::hidden('id', isset($termCondition) ? $termCondition->id : null, ['id' => 'termConditionId']) }}
                {{ Form::label('term_condition', __('messages.vcard.term_condition') . ':', ['class' => 'form-label required']) }}
                <div id="termConditionQuill" class="editor-height" style="height: 200px"></div>
                {{ Form::hidden('term_condition', isset($termCondition) ? $termCondition->term_condition : null, ['id' => 'conditionData']) }}
            </div>
        </div>
        <div class="col-lg-12 d-flex">
            <button type="submit" class="btn btn-primary me-3" id="termConditionSave">
                {{ __('messages.common.save') }}
            </button>
            <a href="{{ route('vcards.index') }}"
                class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
    </div>
@endif
@if ($partName == 'qrcode-customize')
    <input type="hidden" name="part" value="{{ $partName }}" id="qrcodeCustmizePartName">
    <div class="container">
        <div class="row">
            <div class="col order-first">
                {{ Form::label('QR-Code Color', __('messages.vcard.qrcode_color') . ':', ['class' => 'form-label']) }}
                {{ Form::color('qrcode_color', isset($customQrCode['qrcode_color']) ? $customQrCode['qrcode_color'] : null, ['class' => 'form-control form-control-color w-50 mb-3', 'id' => 'qrcode_color']) }}
            </div>
            <div class="col">
                {{ Form::label('Background Color', __('messages.vcard.back_color') . ':', ['class' => 'form-label']) }}
                {{ Form::color('background_color', isset($customQrCode['background_color']) ? $customQrCode['background_color'] : null, ['class' => 'form-control form-control-color w-50 mb-3', 'id' => 'background_color']) }}
            </div>
            <div class="col order-last form-check form-switch mt-8">
                <input class="form-check-input" name="applySetting" type="checkbox" id="flexSwitchCheckChecked"
                    {{ isset($customQrCode['applySetting']) ? ($customQrCode['applySetting'] == 1 ? 'checked' : '') : '' }}>
                <label class="form-check-label"
                    for="flexSwitchCheckChecked">{{ __('messages.common.apply_changes') }}</label>
            </div>
        </div>
        <div class="row">
            <div class="mb-5">
                <label for="exampleInputSelect2" class="form-label">{{ __('messages.vcard.qrcode_style') }}</label>
                {{ Form::select('style', App\Models\QrcodeEdit::QRCODE_STYLE, isset($customQrCode['style']) ? $customQrCode['style'] : null, ['class' => 'form-control form-select', 'data-control' => 'select2', 'id' => 'qrcodeStyle', 'wire:ignore']) }}
            </div>
            <div class="mb-5">
                <label for="exampleInputSelect2"
                    class="form-label">{{ __('messages.vcard.qrcode_eye_style') }}</label>
                {{ Form::select('eye_style', App\Models\QrcodeEdit::QRCODE_EYE_STYLE, isset($customQrCode['eye_style']) ? $customQrCode['eye_style'] : null, ['class' => 'form-control form-select', 'data-control' => 'select2', 'id' => 'qrcodeEyeStyle', 'wire:ignore']) }}
            </div>
            <div class="col-lg-12">
                <div class="col-lg-12 d-flex">
                    <button type="submit" class="btn btn-primary me-3" id="custmizationSave">
                        {{ __('messages.common.save') }}
                    </button>
                    <a href="{{ route('vcards.index') }}"
                        class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
                </div>
            </div>
@endif

@if ($partName == 'manage-section')
    <div class="row mt-5">
        <div class="col-12">
            <input type="hidden" name="part" value="{{ $partName }}">
        </div>
        <div class="row mt-5">
            <div class="col-6">
                <input id="" class="form-check-input" type="checkbox" value="1" name="header"
                    checked disabled>
                <label class="form-label mb-0 me-2" for="">
                    <span class="ms-4 d-md-block">{!! __('messages.vcard.header') !!}</span>
                </label>
            </div>
            <div class="col-6">
                <input id="contactListCheckbox" class="form-check-input" type="checkbox" value="1"
                    name="contact_list"
                    {{ (isset($managesection) && $managesection['contact_list']) || empty($managesection) ? 'checked' : '' }}>
                <label class="form-label mb-0 me-2" for="contactListCheckbox">
                    <span class="ms-4 d-md-block">{!! __('messages.vcard.contact') !!}</span>
                </label>
            </div>
            @if(checkFeature('services'))
            <div class="col-6 mt-5">
                <input id="servicesCheckbox" class="form-check-input" type="checkbox" value="1"
                    name="services"
                    {{ (isset($managesection) && $managesection['services']) || empty($managesection) ? 'checked' : '' }}>
                <label class="form-label mb-0 me-2" for="servicesCheckbox">
                    <span class="ms-4 d-md-block">{!! __('messages.vcard.services') !!}</span>
                </label>
            </div>
            @endif
            @if(checkFeature('gallery'))
            <div class="col-6 mt-5">
                <input id="galleriesCheckbox" class="form-check-input" type="checkbox" value="1"
                    name="galleries"
                    {{ (isset($managesection) && $managesection['galleries']) || empty($managesection) ? 'checked' : '' }}>
                <label class="form-label mb-0 me-2" for="galleriesCheckbox">
                    <span class="ms-4 d-md-block">{!! __('messages.vcard.galleries') !!}</span>
                </label>
            </div>
            @endif
            @if(checkFeature('products'))
            <div class="col-6 mt-5">
                <input id="productsCheckbox" class="form-check-input" type="checkbox" value="1"
                    name="products"
                    {{ (isset($managesection) && $managesection['products']) || empty($managesection) ? 'checked' : '' }}>
                <label class="form-label mb-0 me-2" for="productsCheckbox">
                    <span class="ms-4 d-md-block">{!! __('messages.vcard.products') !!}</span>
                </label>
            </div>
            @endif
            @if(checkFeature('testimonials'))
            <div class="col-6 mt-5">
                <input id="testimonialsCheckbox" class="form-check-input" type="checkbox" value="1"
                    name="testimonials"
                    {{ (isset($managesection) && $managesection['testimonials']) || empty($managesection) ? 'checked' : '' }}>
                <label class="form-label mb-0 me-2" for="testimonialsCheckbox">
                    <span class="ms-4 d-md-block">{!! __('messages.vcard.testimonials') !!}</span>
                </label>
            </div>
            @endif
            @if(checkFeature('blog'))
            <div class="col-6 mt-5">
                <input id="blogsCheckbox" class="form-check-input" type="checkbox" value="1" name="blogs"
                    {{ (isset($managesection) && $managesection['blogs']) || empty($managesection) ? 'checked' : '' }}>
                <label class="form-label mb-0 me-2" for="blogsCheckbox">
                    <span class="ms-4 d-md-block">{!! __('messages.vcard.blogs') !!}</span>
                </label>
            </div>
            @endif
            <div class="col-6 mt-5">
                <input id="businessHoursCheckbox" class="form-check-input" type="checkbox" value="1"
                    name="business_hours"
                    {{ (isset($managesection) && $managesection['business_hours']) || empty($managesection) ? 'checked' : '' }}>
                <label class="form-label mb-0 me-2" for="businessHoursCheckbox">
                    <span class="ms-4 d-md-block">{!! __('messages.vcard.business_hours') !!}</span>
                </label>
            </div>
            @if(checkFeature('appointments'))
            <div class="col-6 mt-5">
                <input id="appointmentsCheckbox" class="form-check-input" type="checkbox" value="1"
                    name="appointments"
                    {{ (isset($managesection) && $managesection['appointments']) || empty($managesection) ? 'checked' : '' }}>
                <label class="form-label mb-0 me-2" for="appointmentsCheckbox">
                    <span class="ms-4 d-md-block">{!! __('messages.vcard.appointments') !!}</span>
                </label>
            </div>
            @endif
            <div class="col-6 mt-5">
                <input id="mapCheckbox" class="form-check-input" type="checkbox" value="1" name="map"
                    {{ (isset($managesection) && $managesection['map']) || empty($managesection) ? 'checked' : '' }}>
                <label class="form-label mb-0 me-2" for="mapCheckbox">
                    <span class="ms-4 d-md-block">{!! __('messages.vcard.map') !!}</span>
                </label>
            </div>
            <div class="col-6 mt-5">
                <input id="bannerCheckbox" class="form-check-input" type="checkbox" value="1" name="banner"
                    {{ (isset($managesection) && $managesection['banner']) || empty($managesection) ? 'checked' : '' }}>
                <label class="form-label mb-0 me-2" for="bannerCheckbox">
                    <span class="ms-4 d-md-block">{!! __('messages.front_cms.banner_title') !!}</span>
                </label>
            </div>
            @if(checkFeature('insta_embed'))
            <div class="col-6 mt-5">
                <input id="instaembedCheckbox" class="form-check-input" type="checkbox" value="1"
                    name="insta_embed"
                    {{ (isset($managesection) && $managesection['insta_embed']) || empty($managesection) ? 'checked' : '' }}>
                <label class="form-label mb-0 me-2" for="instaembedCheckbox">
                    <span class="ms-4 d-md-block">{!! __('messages.feature.insta_embed') !!}</span>
                </label>
            </div>
            @endif
            @if(checkFeature('iframes'))
            <div class="col-6 mt-5">
                <input id="iframeCheckbox" class="form-check-input" type="checkbox" value="1" name="iframe"
                    {{ (isset($managesection) && $managesection['iframe']) || empty($managesection) ? 'checked' : '' }}>
                <label class="form-label mb-0 me-2" for="iframeCheckbox">
                    <span class="ms-4 d-md-block">{!! __('messages.vcard.iframe') !!}</span>
                </label>
            </div>
            @endif
            <div class="col-6 mt-5">
                <input id="newsLatterPopupCheckbox" class="form-check-input" type="checkbox" value="1"
                    name="news_latter_popup"
                    {{ (isset($managesection) && $managesection['news_latter_popup']) || empty($managesection) ? 'checked' : '' }}>
                <label class="form-label mb-0 me-2" for="newsLatterPopupCheckbox">
                    <span class="ms-4 d-md-block">{!! __('messages.vcard.newslatter_popup') !!}</span>
                </label>
            </div>
        </div>
        <div class="col-lg-12 d-flex mt-5">
            <button type="submit" class="btn btn-primary me-3">
                {{ __('messages.common.save') }}
            </button>
            <a href="{{ route('vcards.index') }}"
                class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
    </div>
@endif

@if ($partName == 'dynamic_vcard')
    <input type="hidden" name="part" value="{{ $partName }}">
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-6 mb-5">
                <div class="row">
                    <div class="col-6 order-first text-md-start text-center">
                        {{ Form::label('Primary Color', __('messages.vcard.primary_color') . ':', ['class' => 'form-label']) }}
                        {{ Form::color('primary_color', isset($dynamicVcard['primary_color']) ? $dynamicVcard['primary_color'] : '#b8ff69', ['class' => 'form-control form-control-color w-100 mb-3 mx-md-0 mx-auto', 'id' => 'primary_color']) }}
                    </div>
                    <div class="col-6 text-md-start text-center">
                        {{ Form::label('Background Secondary color', __('messages.vcard.background_secondary_color') . ':', ['class' => 'form-label']) }}
                        {{ Form::color('back_color', isset($dynamicVcard['back_color']) ? $dynamicVcard['back_color'] : '#224754', ['class' => 'form-control form-control-color w-100 mb-3 mx-md-0 mx-auto', 'id' => 'back_color']) }}
                    </div>
                    <div class="col-6 text-md-start text-center">
                        {{ Form::label('Background color', __('messages.vcard.background_color') . ':', ['class' => 'form-label']) }}
                        {{ Form::color('back_seconds_color', isset($dynamicVcard['back_seconds_color']) ? $dynamicVcard['back_seconds_color'] : '#0f2f3a', ['class' => 'form-control form-control-color w-100 mb-3 mx-md-0 mx-auto', 'id' => 'back_seconds_color']) }}
                    </div>
                    <div class="col-6 text-md-start text-center">
                        {{ Form::label('Button Text Color', __('messages.vcard.button_text_color') . ':', ['class' => 'form-label']) }}
                        {{ Form::color('button_text_color', isset($dynamicVcard['button_text_color']) ? $dynamicVcard['button_text_color'] : '#2d2624', ['class' => 'form-control form-control-color w-100 mb-3 mx-md-0 mx-auto', 'id' => 'button_text_color']) }}
                    </div>
                    <div class="col-6 text-md-start text-center">
                        {{ Form::label('Label Text Color', __('messages.vcard.label_text_color') . ':', ['class' => 'form-label']) }}
                        {{ Form::color('text_label_color', isset($dynamicVcard['text_label_color']) ? $dynamicVcard['text_label_color'] : '#ffffff', ['class' => 'form-control form-control-color w-100 mb-3 mx-md-0 mx-auto', 'id' => 'text_label_color']) }}
                    </div>
                    <div class="col-6 text-md-start text-center">
                        {{ Form::label('Description Text Color', __('messages.vcard.description_text_color') . ':', ['class' => 'form-label']) }}
                        {{ Form::color('text_description_color', isset($dynamicVcard['text_description_color']) ? $dynamicVcard['text_description_color'] : '#9facb0', ['class' => 'form-control form-control-color w-100 mb-3 mx-md-0 mx-auto', 'id' => 'text_description_color']) }}
                    </div>
                    <div class="row">
                    <div class="col-6 text-md-start text-center">
                        {{ Form::label('Cards Background', __('messages.vcard.card_back') . ':', ['class' => 'form-label']) }}
                        {{ Form::color('cards_back', isset($dynamicVcard['cards_back']) ? $dynamicVcard['cards_back'] : '#ffffff', ['class' => 'form-control form-control-color w-100 mb-3 mx-md-0 mx-auto', 'id' => 'cards_back']) }}
                    </div>
                    </div>
                    <div class="col text-md-start text-center">
                        {{ Form::label('Sticky button', __('messages.vcard.sticky_btn') . ':', ['class' => 'form-label']) }}
                        <div class="col">
                            <label class="button-label mx-2 mb-3">
                                <input type="radio" name="sticky_bar" class="sticky-btn" value="0"{{ isset($dynamicVcard['sticky_bar']) && $dynamicVcard['sticky_bar'] == 0 ? 'checked' : '' }}>
                                <span class="sticky-btn-title">{{ __('messages.vcard.left') }}</span>
                            </label>
                            <label class="button-label mx-2">
                                <input type="radio" name="sticky_bar" class="sticky-btn" value="1"{{ empty($dynamicVcard) || $dynamicVcard['sticky_bar'] == 1 ? 'checked' : '' }}>
                                <span class="sticky-btn-title">{{ __('messages.vcard.right') }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-5 mt-5">
                <div class="dynamic-vcard">
                    @include('vcards.dynamic')
                </div>
            </div>
        </div>
            <div class="col-lg-12 mt-5">
                <div class="col-lg-12 d-flex">
                    <button type="submit" class="btn btn-primary me-3" id="dynamicColorSave">
                        {{ __('messages.common.save') }}
                    </button>
                    <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
                </div>
            </div>
    </div>
@endif
