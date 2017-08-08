<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Sales Input</title>

  {!! Html::style('css/bootstrap.min.css') !!}
  {!! Html::style('css/sales_input_table.css') !!}
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
          <td rowspan="2" class="title">Sales Input</td>
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
            <th rowspan="1" colspan="1" class="border-disable"></th>
            @for ($i = 0; $i < 7; $i++)
              <th class="{{ $i != 0 ? $i != 6 ? 'border-thin-bottom border-thick-top border-thin-left'
                  : 'border-thin-bottom border-thick-top border-thin-left border-thick-right'
                  : 'border-thin-bottom border-thick-top border-thick-left' }} }}">
                {!! !empty($salesInputList[Carbon\Carbon::now()->subDays(7 - $i)->format('Y-m-d')])
                   ? $salesInputList[Carbon\Carbon::now()->subDays(7 - $i)->format('Y-m-d')]['ignore'] == 1
                   ? Carbon\Carbon::now()->subDays(7 - $i)->format('m/d/Y').nl2br('<br/>(ignored)')
                   : Carbon\Carbon::now()->subDays(7 - $i)->format('m/d/Y') : Carbon\Carbon::now()->subDays(7 - $i)->format('m/d/Y').nl2br('<br/>(missed)') !!}
              </th>
            @endfor
          </tr>
          @for ($index = 0; $index < 24; $index++)
            <tr>
              <th class="time border-thin-right border-thin-bottom border-thick-left {{ $index == 0 ? 'border-thick-top' : '' }}">
                {{ $index < 7 || $index > 18 ? ($index + 6) % 24 : $index - 6 }}:00
                - {{ $index < 6 || $index > 17 ? ($index + 7) % 24 : $index - 5 }}:00
                {{ $index < 6 || $index > 17 ? $index == 5 ? 'Noon':'AM' : 'PM' }}
              </th>
              @for ($i = 0; $i < 7; $i++)
                <td class="border-thin-bottom {{ $i == 6 ? 'border-thick-right' : 'border-thin-right' }}">
                  {{ !empty($salesInputList[Carbon\Carbon::now()->subDays(7 - $i)->format('Y-m-d')]) ?
                     '$'.json_decode(json_encode($salesInputList[Carbon\Carbon::now()->subDays(7 - $i)->format('Y-m-d')]))
                     ->{($index + 6) % 24 + 1 < 10 ? '0'.(($index + 6) % 24 + 1).'00' : (($index + 6) % 24 + 1).'00'}
                     : 'Missed' }}
                </td>
              @endfor
            </tr>
          @endfor
        </tbody>
      </table>
    </div><!-- end .col-md-12 -->
    <div class="col-md-12">
      <table class="table">
        <tbody>
          <tr>
            <th rowspan="1" colspan="1" class="border-disable"></th>
            @for ($i = 0; $i < 7; $i++)
              <th class="{{ $i != 0 ? $i != 6 ? 'border-thin-bottom border-thick-top border-thin-left'
                  : 'border-thin-bottom border-thick-top border-thin-left border-thick-right'
                  : 'border-thin-bottom border-thick-top border-thick-left' }}">
                {!! !empty($salesInputList[Carbon\Carbon::now()->subDays(14 - $i)->format('Y-m-d')])
                   ? $salesInputList[Carbon\Carbon::now()->subDays(14 - $i)->format('Y-m-d')]['ignore'] == 1
                   ? Carbon\Carbon::now()->subDays(14 - $i)->format('m/d/Y').nl2br('<br/>(ignored)')
                   : Carbon\Carbon::now()->subDays(14 - $i)->format('m/d/Y') : Carbon\Carbon::now()->subDays(14 - $i)->format('m/d/Y').nl2br('<br/>(missed)') !!}
              </th>
            @endfor
          </tr>
          @for ($index = 0; $index < 24; $index++)
            <tr>
              <th class="time border-thin-right border-thin-bottom border-thick-left {{ $index == 0 ? 'border-thick-top' : '' }}">
                {{ $index < 7 || $index > 18 ? ($index + 6) % 24 : $index - 6 }}:00
                - {{ $index < 6 || $index > 17 ? ($index + 7) % 24 : $index - 5 }}:00
                {{ $index < 6 || $index > 17 ? $index == 5 ? 'Noon':'AM' : 'PM' }}
              </th>
              @for ($i = 0; $i < 7; $i++)
                <td class="border-thin-bottom {{ $i == 6 ? 'border-thick-right' : 'border-thin-right' }}">
                  {{ !empty($salesInputList[Carbon\Carbon::now()->subDays(14 - $i)->format('Y-m-d')]) ?
                     '$'.json_decode(json_encode($salesInputList[Carbon\Carbon::now()->subDays(14 - $i)->format('Y-m-d')]))
                     ->{($index + 6) % 24 + 1 < 10 ? '0'.(($index + 6) % 24 + 1).'00' : (($index + 6) % 24 + 1).'00'}
                     : 'Missed' }}
                </td>
              @endfor
            </tr>
          @endfor
        </tbody>
      </table>
    </div><!-- end .col-md-12 -->
  </div><!-- end .section-body -->
</div>

</body>
</html>
