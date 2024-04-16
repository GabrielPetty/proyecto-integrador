<?php

require_once '../../config/db-config.php';

class AlarmaService{

    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function verAlarmas(){

        $sql = "SELECT alarmas.id, productos.name, productos.sn, productos.cant, alarmas.stockAviso, alarmas.estado
        FROM productos
        INNER JOIN alarmas ON productos.id = alarmas.productoFK;";
        $result = $this->conexion->query($sql);
        $alarmasData = array();

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                $datos = array(
                    "id" => $row["id"],
                    "name" => $row["name"],
                    "sn" => $row["sn"],
                    "cant" => $row["cant"],
                    "stockAviso" => $row["stockAviso"],
                    "estado" => $row["estado"],
                );

                $alarmasData[] = $datos;

            }
        }

        // ---- Devuelve todos los datos
        return $alarmasData;
    }

    
    public function cerrarConexion()
    {
        $this->conexion->close();
    }
}