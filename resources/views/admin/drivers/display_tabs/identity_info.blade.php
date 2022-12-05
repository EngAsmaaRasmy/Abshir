            
            <div class="card form-card">
                <div class="card-header">
                    <h4 class="form-section"><i class="fa fa-motorcycle"></i> معلومات الهويه</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">

                        <div class="form-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label"> رقم البطاقة   : </label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$identity_info->identity_number ?? '' }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label">تاريح الإنتهاء : </label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$identity_info->expiry_date ?? '' }}" />
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label">الجنسية : </label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$identity_info->nationality ?? '' }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label">تاريخ الميلاد       : </label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$identity_info->birthday ?? '' }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label">الديانة         : </label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$identity_info->religion ?? '' }}" />
                                        </div>
                                    </div>
                                </div>
                   
                                                                <div class="col-md-6">
</div>
                    
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label">صوره الرخصة   : </label>
                                        <div class="col-sm-10">
                                                    <img src="{{url($identity_info->identity_image ?? '' )}}" alt="..." class="img-thumbnail">
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                            </div>
                         
                         
                          
                        </div>
                    </div>
                </div>
            </div>