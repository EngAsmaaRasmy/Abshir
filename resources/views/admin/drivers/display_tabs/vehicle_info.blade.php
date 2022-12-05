            <div class="card form-card">
                <div class="card-header">
                    <h4 class="form-section"><i class="fa fa-motorcycle"></i> معلومات المركبه</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">

                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b> رقم رخصة السيارة:
                                            </b></label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext"
                                                id="staticEmail" value="{{ $license_info->license_number ?? '' }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b> تاريخ الإنتهاء:
                                            </b></label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext"
                                                id="staticEmail" value="{{ $license_info->expiry_date ?? '' }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>الماركة :
                                            </b></label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext"
                                                id="staticEmail" value="{{ $vehicle_info->marker->marker ?? '' }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>النوع : </b></label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext"
                                                id="staticEmail" value="{{ $vehicle_info->model->model ?? '' }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>سنه الإصدار :
                                            </b></label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext"
                                                id="staticEmail" value="{{ $vehicle_info->vehicle_year ?? '' }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>رقم اللوحة :
                                            </b></label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext"
                                                id="staticEmail" value="{{ $vehicle_info->plate_number ?? '' }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>لون المركبه :
                                            </b></label>
                                        <div class="col-sm-10">
                                            <input type="color" readonly class="form-control-plaintext"
                                                id="staticEmail"value="{{ $vehicle_info->vehicle_color ?? '' }}"style="width:100px;height:80px;" />
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>صوره رخصه المركبه
                                                الامامية : </b></label>
                                        <div class="col-sm-10">
                                            <a href="{{ url($vehicle_info->vehicle_license_image ?? '') }}" target="_blank">
                                                <img src="{{ url($vehicle_info->vehicle_license_image ?? '') }}" alt="..."
                                                    class="img-thumbnail"style="width:200px;height:100px;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>صوره رخصه المركبه
                                                الخلفية : </b></label>
                                        <div class="col-sm-10">
                                            <a href="{{ url($vehicle_info->vehicle_license_image_back ?? '') }}" target="_blank">
                                            <img src="{{ url($vehicle_info->vehicle_license_image_back ?? '') }}"
                                                alt="..." class="img-thumbnail"style="width:200px;height:100px;">
                                            </a>
                                        </div>
                                    </div>
                                </div>



                            </div>



                        </div>
                    </div>
                </div>
            </div>
