<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
            <h2 class="text-center mt-1">Control de asistencia de delegados</h2>
        </div>
    </div>

    <div>
        <p><span class="font-bold">Responsable:</span> ______________________________</p>
        <p><span class="font-bold">Fecha:</span>___/___/_____</p>
    </div>

    <table class="rounded-lg w-full mt-10" cellspacing="0">
        <tr class="text-lg font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600" style="background-color: #eee">
            <th class="px-4 py-3" style="width: 90px">Cedula</th>
            <th class="px-4 py-3">Delegado</th>
            <th class="px-4 py-3">Grado</th>
            <th class="px-4 py-3">Firma</th>
        </tr>
        @foreach($invitados as $invitado)
            @if($invitado->confirmacion == 's')
                <tr class="text-gray-700" style="height: 60px">
                    <td class="px-4 py-3 text-ms border">
                        {{ $invitado->cedula }}
                    </td>
                    <td class="px-4 py-3 text-ms border">
                        {{ $invitado->policia }}
                    </td>
                    <td class="px-4 py-3 text-ms border">
                        {{ $invitado->rango }}
                    </td>
                    <td width="200px"></td>
                </tr>
            @endif
        @endforeach
    </table>

    <div class="text-center mt-10">
        <p>____________________________</p>
        <p class="font-bold">Firma del responsable</p>
    </div>

</body>
</html>
