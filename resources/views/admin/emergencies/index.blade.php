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
                        @include('alert.success')
                        @if (Session::has('error'))
                            <div class="row mr-2 ml-2">
                                <button type="text" class="btn btn-lg btn-block btn-outline-danger mb-2"
                                    id="type-error">{{ Session::get('error') }}
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive-sm">
                            <table class="table">
                                <thead class="bg-primary white">
                                    <tr>
                                        <th>#</th>
                                        <th>رقم الرحلة </th>
                                        <th>السائق </th>
                                        <th> العميل</th>
                                        <th>الاجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($emergencies)
                                        @foreach ($emergencies as $emergency)
                                            <tr>
                                                <th scope="row">{{ $emergency->id }}</th>
                                                <td>{{ $emergency->trip_id }}</td>
                                                <td>{{ $emergency->trip->driverRel->fullname  ?? '-----------'}}</td>
                                                <td>{{ $emergency->trip->customerRel->name ?? '-----------'}}</td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <a href="{{ route('emergency.show', $emergency->id) }}"
                                                            class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تتبع
                                                            الرحلة</a>

                                                    </div>
                                                </td>



                                            </tr>
                                        @endforeach
                                    @endisset

                                </tbody>
                            </table>
                            @if ($emergencies->hasPages())
                                <ul class="pager pager-flat">

                                    <li class="{{ $emergencies->onFirstPage() ? 'disabled' : 'enabled' }}">
                                        <a href="{{ $emergencies->previousPageUrl() }}"
                                            onclick="{{ $emergencies->onFirstPage() ? 'return false;' : '' }}"><i
                                                class="ft-arrow-left"></i> السابق</a>
                                    </li>


                                    <li class="{{ $emergencies->hasMorePages() ? 'enabled' : 'disabled' }} ">
                                        <a href="{{ $emergencies->nextPageUrl() }}"
                                            onclick="{{ $emergencies->hasMorePages() ? '' : 'return false;' }}">التالى <i
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
