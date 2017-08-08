<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Cooking Schedule</title>

  {!! Html::style('css/bootstrap.min.css') !!}
  {!! Html::style('css/cooking_schedule_table.css') !!}
  <style>
    .page-break {
      page-break-after: always;
    }
  </style>
</head>
<body>

<!-- =========================

  Content Template

============================== -->
<div class="container">
    @foreach ($dayPartList as $page)

      <div class="row section-header">
        <div class="col-md-12">
          <table class="table">
            <tr>
              <td rowspan="2" class="logo">
                <img src="{{ asset('images/fready_logo_grey.jpg') }}" alt="Fready Logo">
              </td>
              <td rowspan="2" class="title">Cooking Schedule - {{ $shift }}</td>
              <td class="head">Date:</td>
              <td class="body">{{ \Carbon\Carbon::now()->format('m/d/Y') }}</td>
            </tr>
            <tr>
              <td class="head">Restaurant #</td>
              <td class="body">{{ Auth::guard('restaurant')->user()->restaurant_id }}</td>
            </tr>
            <tr>
              <td rowspan="2"></td>
              <td rowspan="2"></td>
              <td class="head">MOD:</td>
              <td class="body">{{ $mod }}</td>
            </tr>
          </table>
        </div>
      </div>

      <div class="row section-body" >
        <div class="col-md-12">

          <table class="table table-sm">
            <tbody>
            <tr>
              <th rowspan="2" colspan="1" class="border-disable"></th>

              @foreach ($menuNameList as $menuName)
                <th colspan="3" class="border-thick">{{ $menuName }}</th>
              @endforeach
            </tr>

            <tr>
              @foreach ($menuNameList as $menuName)
                <td class="subhead-col border-thick-bottom border-thin-right border-thick-left">NEED</td>
                <td class="subhead-col border-thick-bottom border-thin-right">ON HAND</td>
                <td class="subhead-col border-thick-bottom border-thick-right">COOK</td>
              @endforeach
            </tr>

            @foreach ($page as $dayPart => $timeUnitArr)
              @foreach ($timeUnitArr as $time => $unitArr)
                <tr>

                  <th class="{{ ($loop->parent->index == 0) && ($loop->index == 0) ? 'border-thick-top' : '' }} border-thick-right border-thick-left">
                    {{ substr($time, 0, 2) }}:{{ substr($time, 2, 2) }}
                  </th>

                  @foreach ($unitArr as $unit)
                    <td class="border-thin-right">
                      {{ is_array($unit) ? $unit[0] : $unit }}
                    </td>
                    <td class="border-thin-right"></td>
                    <td class="border-thick-right"></td>
                  @endforeach

                </tr>
              @endforeach
            @endforeach
            </tbody>
          </table>
        </div><!-- end .col-md-12 -->
      </div><!-- end .section-body -->

      @if (!$loop->last)
        <div class="page-break"></div>
      @endif
    @endforeach
</div>

</body>
</html>
