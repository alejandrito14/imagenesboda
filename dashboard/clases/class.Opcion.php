<?php

class Opcion
{

    public $db; //objeto de la clase de conexcion

    public $idgrupoopcion;
    public $opcion;
    public $costo;
    public $idgrupo;

    public $idpaquete;
    public $topesecundario;

    //funcion para guardar Grupos

    public function Guardaropcion()
    {
        $query = "INSERT INTO grupoopcion (opcion,costo,idgrupo) VALUES ('$this->opcion','$this->costo','$this->idgrupo')";

        $resp = $this->db->consulta($query);

    }

    public function Guardaropcion2($value = '')
    {
        $query = "INSERT INTO grupoopcion (opcion,costo,idgrupo,idgrupoopcion) VALUES ('$this->opcion','$this->costo','$this->idgrupo','$this->idgrupoopcion')";

        $resp = $this->db->consulta($query);

    }

    /*  public function Actualizaropcion()
    {
    $query = "UPDATE grupoopcion SET opcion='$this->opcion',
    costo='$this->costo',
    idgrupo='$this->idgrupo',
    WHERE idgrupoopcion=$this->idgrupoopcion";

    $resp = $this->db->consulta($query);
    }*/

    //funcion para modificar
    public function ModificarGrupos()
    {
        $query = "UPDATE grupo SET nombregrupo='$this->nombregrupo',
		descripcion='$this->descripcion',
		sincoprecio='$this->sinprecio',
		multiple='$this->multiple',

		estatus='$this->estatus'
		WHERE idGrupos=$this->idGrupos";

        $resp = $this->db->consulta($query);
    }

    public function GuardaGrupoPaquete()
    {
        $query = "INSERT INTO grupopaquetes (idgrupo,idpaquete,topesecundario) VALUES ('$this->idgrupo','$this->idpaquete','$this->topesecundario')";

        $resp = $this->db->consulta($query);

    }

    public function ObtenerOpcionesdeGrupo()
    {
        $sql = "SELECT * FROM grupoopcion WHERE idgrupo=" . $this->idgrupos . "";

        $resp = $this->db->consulta($sql);

        return $resp;

    }

}
