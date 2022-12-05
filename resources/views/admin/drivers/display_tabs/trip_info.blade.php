<div class="card form-card">
    <div class="card-header">
        <h4 class="form-section"><i class="fa fa-motorcycle"></i> كشق حساب السائق</h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
    </div>
    <table>
        <div class="table-responsive-sm">
            <table class="table">
                <thead class="bg-primary white">
                <tr>
                    <th>#</th>
                    <th>القيمه</th>
                    <th>النوع</th>
                    <th>نوع الاضافه</th>
                    <th> بواسطة</th>
                    <th> تاريخ الاضافه</th>
                </tr>
                </thead>
                <tbody>
                @isset($wallet_history)
                    @foreach($wallet_history as $wallet)
                        <tr>
                            <th scope="row">{{$wallet->id}}</th>
                            <td>{{$wallet->value}}</td>
                            <td>@if($wallet->type == "Add") إضافه@else خصم@endif</td>
                            <td>@if($wallet->user_type == "Admin")أدمن @else عميل @endif</td>
                            <td>
                                @if($wallet->user_type == "Admin")
                                    {{ $wallet->adminName }}
                                @else
                                    {{ $wallet->customerName }}
                                @endif

                            </td>
                            <td>{{ $wallet->created_at }}</td>
                        </tr>
                    @endforeach
                @endisset

                </tbody>
            </table>
            @if($wallet_history->hasPages())
            <ul class="pager pager-flat">

                <li class="{{$wallet_history->onFirstPage()?'disabled':"enabled"}}">
                    <a href="{{$wallet_history->previousPageUrl()}}"  onclick="{{$wallet_history->onFirstPage()?"return false;":""}}" ><i class="ft-arrow-left"></i> السابق</a>
                </li>


                <li class="{{$wallet_history->hasMorePages()?'enabled':"disabled"}} ">
                    <a href="{{$wallet_history->nextPageUrl()}}" onclick="{{$wallet_history->hasMorePages()?"":"return false;"}}" >التالى <i class="ft-arrow-right"></i></a>
                </li>


            </ul>

                @endif

        </div>
    </table>
</div>

