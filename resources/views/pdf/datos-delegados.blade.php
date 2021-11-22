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
        .page_break {
            page-break-before: always;
        }

        hr{
            height: 1px;
            background-color: #ccc;
            border: none;
        }

    </style>
</head>
<body class="p-6">

@foreach($delegados as $delegado)

    <div id="header">
        <div class="text-center">
            <img src="{{ asset('images/logo.png') }}" width="250px">
        </div>
    </div>

    <div class="text-center mt-10">
        <img src="{{ asset('storage/' . $delegado->user->profile_photo_path) }}" width="148px" height="184px">
    </div>

    <table class="rounded-lg mt-10" cellspacing="0" border="0">
        <tr>
            <td>
                <strong>Grado:</strong>
            </td>
            <td>
                {{ $delegado->rango->descripcion }}
            </td>
        </tr>

        <tr>
            <td>
                <strong>Nombre:</strong>
            </td>
            <td>
                {{  $delegado->nombres . ' ' . $delegado->apellido_paterno. ' '.  $delegado->apellido_materno }}
            </td>
        </tr>

        <tr>
            <td>
                <strong>Cedula:</strong>
            </td>
            <td>
                {{ $delegado->cedula }}
            </td>
        </tr>

        <tr>
            <td>
                <strong>Correo electrónico:</strong>
            </td>
            <td>
                {{ $delegado->correo }}
            </td>
        </tr>

        <tr>
            <td>
                <strong>Numero de celular:</strong>
            </td>
            <td>
                {{ $delegado->celular }}
            </td>
        </tr>

        <tr>
            <td>
                <strong>Numero convencional:</strong>
            </td>
            <td>
                {{ $delegado->convencional }}
            </td>
        </tr>
    </table>
    <div class="page_break"></div>
@endforeach

</body>
</html>
