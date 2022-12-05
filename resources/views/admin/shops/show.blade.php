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
                            <p style="font-weight: bold; font-size: 18px">المحلات</p>
                        </div>
                        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="file" name="file" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-info">إضافة محلات جديدة</button>
                                </div>
                            </div>
                            <br>

                        </form>
                        @include('alert.success')
                        @if (Session::has('error'))
                            <div class="row mr-2 ml-2">
                                <button type="text" class="btn btn-lg btn-block btn-outline-danger mb-2"
                                    id="type-error">{{ Session::get('error') }}
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-primary white">
                                    <tr>
                                        <th>#</th>
                                        <th>اللوجو</th>
                                        <th>اسم المحل</th>
                                        <th>اسم المستخدم</th>
                                        <th>رقم الهاتف</th>
                                        <th>العنوان</th>
                                        {{-- <th>عدد الاوردرات</th>
                                        <th>عدد الاوردرات الملغيه</th>
                                        <th>اجمالى المبيعات</th> --}}
                                        <th>الاجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($shops)
                                        @foreach ($shops as $shop)
                                            <tr>
                                                <th scope="row">{{ $shop->id }}</th>
                                                <td>
                                                    <div>
                                                        <img class="category-image" src="{{ asset($shop->logo) }}">
                                                    </div>
                                                </td>
                                                <td>{{ $shop->name }}</td>
                                                <td>{{ $shop->username }}</td>
                                                <td>{{ $shop->phone }}</td>
                                                <td>
                                                    <div style="width: 20em">
                                                        {{ $shop->address }}
                                                    </div>
                                                </td>

                                                {{-- <td>{{ $shop->order_count }}</td>
                                                <td>{{ $shop->cancelled_orders_count }}</td>
                                                <td>{{ $shop->total_earnings }}</td> --}}

                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <a href="{{ route('shop.edit', $shop->id) }}"
                                                            class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a>
                                                        <a href="{{ route('shop.delete', $shop->id) }}"
                                                            class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">حذف</a>

                                                    </div>
                                                </td>


                                            </tr>
                                        @endforeach
                                    @endisset

                                </tbody>
                            </table>
                            @if ($shops->hasPages())
                                <ul class="pager pager-flat">

                                    <li class="{{ $shops->onFirstPage() ? 'disabled' : 'enabled' }}">
                                        <a href="{{ $shops->previousPageUrl() }}"
                                            onclick="{{ $shops->onFirstPage() ? 'return false;' : '' }}"><i
                                                class="ft-arrow-left"></i> السابق</a>
                                    </li>


                                    <li class="{{ $shops->hasMorePages() ? 'enabled' : 'disabled' }} ">
                                        <a href="{{ $shops->nextPageUrl() }}"
                                            onclick="{{ $shops->hasMorePages() ? '' : 'return false;' }}">التالى <i
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
