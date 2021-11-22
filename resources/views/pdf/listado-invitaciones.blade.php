<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.7/utilities.min.css">
    <title>Document</title>
    <style>
        /*.text-center{*/
        /*    text-align: center;*/
        /*}*/

        table tr td, table tr th {
            border: 1px solid #dadada
        }

    </style>
</head>
<body class="p-6">
    <div id="header">
        <div class="text-center">
            <img src="{{ asset('images/logo.png') }}" width="150px">
        </div>
        <div>
            <h1 class="text-center mb-0">Servicio de cesantía de la Policía Nacional</h1>
            <h2 class="text-center mt-1">Lista de invitados al evento</h2>
        </div>
    </div>

{{--    <div>--}}
{{--        <p><span class="font-bold">Responsable:</span> ______________________________</p>--}}
{{--        <p><span class="font-bold">Fecha:</span>___/___/_____</p>--}}
{{--    </div>--}}

    <table class="rounded-lg w-full mt-10" cellspacing="0">
        <tr class="text-sm font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600" style="background-color: #eee">
            <th class="px-4 py-3"  style="width: 90px">Cuadrante</th>
            <th class="px-4 py-3"  style="width: 60px">Mesa</th>
            <th class="px-4 py-3" style="width: 50px">Silla</th>
            <th class="px-4 py-3"  style="width: 80px">Grado</th>
            <th class="px-4 py-3" style="width: 90px">Cedula</th>
            <th class="px-4 py-3"  style="width: 150px">Delegado</th>
            <th class="px-4 py-3"  style="width: 55px">Confirmación</th>
            <th class="px-4 py-3"  style="width: 50px">Asitencia</th>
        </tr>
        @foreach($invitaciones as $invitacion)
                <tr class="text-gray-700">
                    <td class="px-4 py-3 text-ms border">
                        {{ $invitacion->cuadrante }}
                    </td>
                    <td class="px-4 py-3 text-ms border">
                        {{ $invitacion->mesa }}
                    </td>
                    <td class="px-4 py-3 text-ms border">
                        {{ $invitacion->silla }}
                    </td>
                    <td class="px-4 py-3 text-ms border">
                        {{ $invitacion->rango }}
                    </td>
                    <td class="px-4 py-3 text-ms border">
                        {{ $invitacion->cedula }}
                    </td>
                    <td class="px-4 py-3 text-ms border">
                        {{ $invitacion->policia }}
                    </td>
                    <td class="px-4 py-3 text-ms border">
                        {{  $estadoConfirmacion[$invitacion->confirmacion] }}
                    </td>
                    <td class="px-4 py-3 text-ms border">
                        {{ $estadoAsistencia[$invitacion->asistencia] }}
                    </td>
                </tr>
        @endforeach
    </table>

</body>
</html>
