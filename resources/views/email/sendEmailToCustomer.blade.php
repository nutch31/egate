@extends('layouts.app')

@section('content')

    <h3>@lang('sendEmailToCustomer.welcome') {{$campaign->name}}</h3>
    <p style="text-indent: 50px;">@lang('sendEmailToCustomer.subject')</p>

    <table class="center" style="width:100%; text-align:left;">
        <thead>
        <tr style="background-color:#3c3c3c; color:white;">
            <th>@lang('sendEmailToCustomer.head_table')</th>
            <td></td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th style="width:40%">@lang('sendEmailToCustomer.campaign_name')</th>
            <td style="width:60%">{{$campaign->name}}</td>
        </tr>

        <tr style="background-color:#f0f0f0;">
            <td>@lang('sendEmailToCustomer.data')</td>
            <td style="background-color:#f0f0f0;"></td>
        </tr>

        <tr>
            <td>@lang('sendEmailToCustomer.submitted_date_time')</td>
            <td>{{$lead->submitted_date_time}}</td>
        </tr>

        <tr>
            <td>@lang('sendEmailToCustomer.name')</td>
            <td>{{$lead->form_name}}</td>
        </tr>

        <tr>
            <td>@lang('sendEmailToCustomer.email')</td>
            <td>{{$lead->form_email}}</td>
        </tr>

        <tr>
            <td>@lang('sendEmailToCustomer.phone')</td>
            <td>{{$lead->form_phone}}</td>
        </tr>

        <tr style="background-color:#f0f0f0;">
            <td>@lang('sendEmailToCustomer.content')</td>
            <td></td>
        </tr>

        @foreach(json_decode($lead->form_content, true) as $key => $value)
            <tr>
                <td>{{$key}} :</td>
                @if(is_array($value))
                    <td>{{$value[0]}}</td>
                @else
                    <td>{{$value}}</td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
