<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Product Mix</title>

  {{--<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css" media="print" />--}}
  {{--<link rel="stylesheet" href="{{ asset('css/product_mix_table.css') }}" type="text/css" media="print" />--}}
  {!! Html::style('css/bootstrap.min.css') !!}
  {!! Html::style('css/product_mix_table.css') !!}
  <style>

  </style>
</head>
<body>

<!-- =========================

  Content Template

============================== -->
<div class="container">
  <div class="row section-header">
    <div class="col-md-12">
      <table class="table">
        <tr>
          <td rowspan="2" class="logo">
            <img src="{{ asset('images/fready_logo_grey.jpg') }}" alt="Fready Logo">
          </td>
          <td rowspan="2" class="title">Product Mix</td>
          <td class="head">Date:</td>
          <td class="body">{{ \Carbon\Carbon::now()->format('m/d/Y') }}</td>
        </tr>
        <tr>
          <td class="head">Restaurant #</td>
          <td class="body">{{ Auth::guard('restaurant')->user()->restaurant_id }}</td>
        </tr>
      </table>
    </div>
  </div>

  <div class="row section-body">
    <div class="col-md-12">

      <table class="table">
        <tbody>
        <tr>
          <th rowspan="2" colspan="2" class="border-disable"></th>
          <th colspan="7" class="border-thick">Avg. Pieces Sold On Any Given...</th>
        </tr>
        <tr>
          <td class="border-thin-bottom border-thin-right border-thick-left">Monday</td>
          <td class="border-thin-bottom border-thin-right">Tuesday</td>
          <td class="border-thin-bottom border-thin-right">Wednesday</td>
          <td class="border-thin-bottom border-thin-right">Thursday</td>
          <td class="border-thin-bottom border-thin-right">Friday</td>
          <td class="border-thin-bottom border-thin-right">Saturday</td>
          <td class="border-thin-bottom border-thick-right">Sunday</td>
        </tr>

        @if (count($productMixRequiredList) > 0)
          <tr>
            <th colspan="2" class="item-group border-thick-top border-thick-left">Regular Offer</th>
            <th colspan="7" class="border-thick-right border-thick-left blank-row"></th>
          </tr>
        @endif

        @foreach ($productMixRequiredList as $row)
          <tr>
            <th class="border-thin-right border-thin-bottom border-thick-left">
              {{ $row['menu_item_name'] }}
            </th>
            <th class="border-thick-right border-thin-bottom border-thin-left">
              {{ $row['unit'] }}
            </th>
            <td class="border-thin-bottom border-thin-right">
              {{ $row['monday'] }}
            </td>
            <td class="border-thin-bottom border-thin-right">
              {{ $row['tuesday'] }}
            </td>
            <td class="border-thin-bottom border-thin-right">
              {{ $row['wednesday'] }}
            </td>
            <td class="border-thin-bottom border-thin-right">
              {{ $row['thursday'] }}
            </td>
            <td class="border-thin-bottom border-thin-right">
              {{ $row['friday'] }}
            </td>
            <td class="border-thin-bottom border-thin-right">
              {{ $row['saturday'] }}
            </td>
            <td class="border-thin-bottom border-thick-right">
              {{ $row['sunday'] }}
            </td>
          </tr>
        @endforeach

        @if (count($productMixLimitedList) > 0)
          <tr>
            <th colspan="2" class="item-group border-thick-left">Limited Time Offer</th>
            <th colspan="7" class="border-thick-right border-thick-left blank-row"></th>
          </tr>
        @endif

        @foreach ($productMixLimitedList as $row)
          <tr>
            <th class="border-thin-right border-thick-left">
              {{ $row['menu_item_name'] }}
            </th>
            <th class="border-thick-right border-thin-left">
              {{ $row['unit'] }}
            </th>
            <td class="border-thin-right">
              {{ $row['monday'] }}
            </td>
            <td class="border-thin-right">
              {{ $row['tuesday'] }}
            </td>
            <td class="border-thin-right">
              {{ $row['wednesday'] }}
            </td>
            <td class="border-thin-right">
              {{ $row['thursday'] }}
            </td>
            <td class="border-thin-right">
              {{ $row['friday'] }}
            </td>
            <td class="border-thin-right">
              {{ $row['saturday'] }}
            </td>
            <td class="border-thick-right">
              {{ $row['sunday'] }}
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>

    </div><!-- end .col-md-12 -->
  </div><!-- end .section-body -->
</div>

</body>
</html>
