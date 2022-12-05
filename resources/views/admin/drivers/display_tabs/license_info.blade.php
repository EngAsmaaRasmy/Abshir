            <div class="card form-card">
                <div class="card-header">
                    <h4 class="form-section"><i class="fa fa-motorcycle"></i> معلومات المستندات</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">

                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>الصورة الجنائية :
                                            </b></label>
                                        <div class="col-sm-10">
                                            <a href="{{ url($document->criminal_chip_image ?? '') }}" target="_blank">
                                                <img src="{{ url($document->criminal_chip_image ?? '') }}" alt="..."
                                                    class="img-thumbnail"style="width:200px;height:100px;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>تقرير الفحص:
                                            </b></label>
                                        <div class="col-sm-10">
                                            <a href="{{ url($document->examination_report ?? '') }}" target="_blank">
                                                <img src="{{ url($document->examination_report ?? '') }}" alt="..."
                                                    class="img-thumbnail"style="width:200px;height:100px;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>صورة العقد:
                                            </b></label>
                                        <div class="col-sm-10">
                                            <a href="{{ url($document->contract_image ?? '') }}" target="_blank">
                                                <img src="{{ url($document->contract_image ?? '') }}" alt="..."
                                                    class="img-thumbnail"style="width:200px;height:100px;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
