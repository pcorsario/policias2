<?php


namespace App\Services\AsignacionSillas;


use App\Models\Silla;

class CrearAsignacionService
{

    public function execute(int $idSilla, int $idPolicia, String $confirmacion = 'n', String $asistencia = 'n')
    {
        //Primero se obtiene la tabla de la relacion entre las dos tablas de muchos a muchos (SILLAS - POLICIAS)
        $silla = Silla::find($idSilla);

        // Se utilizá el objeto instanciado del la línea anterior y luego se utiliza el método policias()
        // que se creó en el modelo de sillas(Método de la relación muchos a muchos)
        // ahora para agregar el registro se debe usar el método attach, y el primer parametro que se envía
        // es el del policia ya que es el método policias() que se utilizó
        // en caso de querer enviar mas parametros a esta tabla pivot se lo hace mediante un array(clave-valor)
        $silla->policias()->attach($idPolicia, ['confirmacion' => $confirmacion, 'asistencia' => $asistencia]);

        // para obtener los datos del registro guardado se utiliza el siguiente método
        // en caso de solo querer obtener el primer registro entonces usar first()
        // en caso de querer obtener todos los registros de esa relación usar get()
        return $silla->policias()->first()->pivot;
    }

}
