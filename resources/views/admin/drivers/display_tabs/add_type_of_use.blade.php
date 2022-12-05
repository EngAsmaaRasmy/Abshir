            <div class="card form-card">
                <div class="card-header">
                    <h4 class="form-section"><i class="fa fa-motorcycle"></i> تحديد طريقة الاستخدام</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        @include('alert.success')
                        @include('alert.error')
                        <form class="form" method="post" action="{{ route('driver.typeofUse', $driver->id) }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><input type="checkbox" name="is_delivery" value="1"
                                            {{ $driver->is_delivery == 1 ? 'checked' : '' }}>
                                            توصيل طلبات    
                                        </label>
                                        <br>
                                        <label><input type="checkbox" name="is_ride" value="1"
                                            {{ $driver->is_ride == 1 ? 'checked' : '' }}>
                                            توصيل عملاء</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-body">
                                <div class="form-actions">
                                    <a href="{{ route('admin.home') }}" type="button" class="btn btn-warning mr-1"
                                        style="color: white">
                                        <i class="ft-x"></i> الغاء
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="la la-check-square-o"></i> حفظ
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
