<div class="card form-card">
    <div class="card-header">
        <h4 class="form-section"><i class="fa fa-motorcycle"></i> معلومات السائق</h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
    </div>
    <div class="card-content collapse show">
        <div class="card-body">

            <div class="form-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label"><b>الإسم : </b></label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                    value="{{ $driver->fullname ?? ' ' }}" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label"><b>رقم الهاتف : </b></label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                    value="{{ $driver->phone ?? ' ' }}" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label"><b>تاريخ الميلاد : </b></label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                    value="{{ $driver->date_of_birth ?? '' }}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label"><b>الحالة : </b></label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                    value="{{ $driver->active == 1 ? 'مفعل' : 'غير مفعل' }}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label"><b>الرقم القومى : </b></label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                    value="{{ $identity_info->identity_number ?? '' }}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label"><b> النوع: </b></label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                    value="{{ $identity_info->gender ?? '' }}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label"><b>رخصه القيادة : </b></label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                    value="{{ $driver->license_number ?? '' }}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label"><b>تاريخ الإنتهاء : </b></label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                    value="{{ $identity_info->expiry_date ?? '' }}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label"><b>الصوره الشخصية: </b></label>
                            <div class="col-sm-10">
                                <a href="{{ url($driver->image ?? '') }}" target="_blank">
                                    <img id="small_image" src="{{ url($driver->image ?? '') }}" alt="..."
                                        class="img-thumbnail " style="width:200px;height:100px;">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label"><b>الصوره الاماميه للبطاقة
                                    الشخصية: </b></label>
                            <div class="col-sm-10">
                                <a href="{{ url($identity_info->identity_image ?? '') }}" target="_blank">
                                    <img src="{{ url($identity_info->identity_image ?? '') }}" alt="..."
                                        class="img-thumbnail" style="width:200px;height:100px;">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label"><b>الصوره االخلفية للبطاقة
                                    الشخصية: </b></label>
                            <div class="col-sm-10">
                                <a href="{{ url($identity_info->identity_image_back ?? '') }}" target="_blank">
                                    <img src="{{ url($identity_info->identity_image_back ?? '') }}" alt="..."
                                        class="img-thumbnail" style="width:200px;height:100px;">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label"><b>صورة رخصه القيادة الامامية:
                                </b></label>
                            <div class="col-sm-10">
                                <a href="{{ url($driver->driving_license ?? '') }}" target="_blank">
                                    <img src="{{ url($driver->driving_license ?? '') }}" alt="..."
                                        class="img-thumbnail" style="width:200px;height:100px;">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label"><b>صورة رخصه القيادة الخلفية:
                                </b></label>
                            <div class="col-sm-10">
                                <a href="{{ url($driver->driving_license_back ?? '') }}" target="_blank">
                                    <img src="{{ url($driver->driving_license_back ?? '') }}" alt="..."
                                        class="img-thumbnail" style="width:200px;height:100px;">
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
