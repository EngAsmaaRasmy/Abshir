@extends('admin.app')
@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
            </div>
            <div class="content-body">


                <div class="card">

                    <div class="card-content collapse show">
                        <div class="card-body">
                            <p style="font-weight: bold; font-size: 18px">السائقين</p>
                        </div>
                        @include('alert.success')
                        @if (Session::has('error'))
                            <div class="row mr-2 ml-2">
                                <button type="text" class="btn btn-lg btn-block btn-outline-danger mb-2"
                                    id="type-error">{{ Session::get('error') }}
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead class="bg-primary white">
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>رقم الهاتف</th>
                                        <th>رقم الاوردر الحالى</th>
                                        <th>عدد الاوردرات</th>
                                        <th>اجمالى المبلغ</th>
                                        <th>الحالة</th>
                                        <th>الاجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($drivers)
                                        @foreach ($drivers as $driver)
                                            <tr>
                                                <th scope="row">{{ $driver->id }}</th>
                                                <td>{{ $driver->fullname }}</td>

                                                <td>{{ $driver->phone }}</td>
                                                <td>{{ $driver->active_order }}</td>
                                                <td>{{ $driver->order_count }}</td>
                                                <td>{{ $driver->total_earnings }}</td>
                                                <td class="text-center"><span
                                                        class="@if ($driver->status == '5') text-success @elseif($driver->status == '6') text-denger @else text-danger @endif">{{ $driver->status == '5' ? 'مفعل' : 'غير مفعل' }}</span>
                                                </td>

                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <a href="{{ route('driver.toggle_active', $driver->id) }}"
                                                            class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">{{ $driver->status == '5' ? 'الغاء التفعيل' : 'تفعيل' }}</a>
                                                        <a href="{{ route('driver.show_driver', $driver->id) }}"
                                                            class="btn btn-outline-success btn-min-width box-shadow-3 mr-1 mb-1">معاينة</a>
                                                        <a href="{{ route('driver.wallet', $driver->id) }}"
                                                            class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">المحفظة</a>
                                                        <a href="{{ route('driver.driver_account', $driver->id) }}"
                                                            class="btn btn-outline-info btn-min-width box-shadow-3 mr-1 mb-1">كشف
                                                            الحساب</a>
                                                        <a href="{{ route('editComment', $driver->id) }}"
                                                            class="btn btn-outline-info btn-min-width box-shadow-3 mr-1 mb-1"> إضافة تعليق</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset

                                </tbody>
                            </table>
                            @if ($drivers->hasPages())
                                <ul class="pager pager-flat">

                                    <li class="{{ $drivers->onFirstPage() ? 'disabled' : 'enabled' }}">
                                        <a href="{{ $drivers->previousPageUrl() }}"
                                            onclick="{{ $drivers->onFirstPage() ? 'return false;' : '' }}"><i
                                                class="ft-arrow-left"></i> السابق</a>
                                    </li>


                                    <li class="{{ $drivers->hasMorePages() ? 'enabled' : 'disabled' }} ">
                                        <a href="{{ $drivers->nextPageUrl() }}"
                                            onclick="{{ $drivers->hasMorePages() ? '' : 'return false;' }}">التالى <i
                                                class="ft-arrow-right"></i></a>
                                    </li>


                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
