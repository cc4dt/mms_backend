<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Qrcode</title>
</head>
<body>
    <table style="width:100%;table-layout:fixed;text-align:center;">
        <tbody>
            @for ($r = 0; $r < ceil($equipment->count() / 4); $r++)
                <tr>
                    @for ($c = 0; $c < 4; $c++)
                        @if ($r*4+$c < $equipment->count())
                            @php
                                $item = $equipment[$r*4+$c];
                            @endphp
                            <td style="padding: 8px">
                                <h3>{{$item->station->name}}</h3>
                                <h4>{{$item->equipment->name}}</h4>
                                {{$item->qrcode}}                        
                                <h4>{{$item->serial}}</h4>
                            </td>
                        @endif
                    @endfor
                </tr>
            @endfor
        </tbody>
    </table>
</body>
</html>