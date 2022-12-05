            
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
                                        <label for="staticEmail" class="col-sm-2 col-form-label">الإسم : </label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $address_info->name ?? '' }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label"> التاريخ   : </label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$address_info->date ?? '' }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label">تاريح التسجيل : </label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$address_info->registration_date ?? '' }}" />
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label">التفاصيل : </label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$address_info->description ?? '' }}" />
                                        </div>
                                    </div>
                                </div>
 
                   
                                                                <div class="col-md-6">
</div>
                    
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label">صوره الرخصة   : </label>
                                        <div class="col-sm-10">
                                                    <img src="{{url($address_info->image ?? '' )}}" alt="..." class="img-thumbnail">
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                            </div>
                         
                         
                          
                        </div>
                    </div>
                </div>
            </div>