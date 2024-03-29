<?php
require_once "conexion.php";
class ModeloFormularios{
    static public function mdlRegistro($tabla,$datos){
        $creado = date("Y-m-d H:i:s");
        $stmt = Conexion::conectar() -> prepare("INSERT INTO $tabla (first_name, last_name, email, password, phone ,created)
        VALUES (:first_name, :last_name, :email, :password, :phone, :created)");

        $stmt -> bindParam(":first_name", $datos["first_name"], PDO::PARAM_STR);
        $stmt -> bindParam(":last_name", $datos["last_name"], PDO::PARAM_STR);
        $stmt -> bindParam(":email", $datos["email"], PDO::PARAM_STR);
        $stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
        $stmt -> bindParam(":phone", $datos["phone"], PDO::PARAM_STR);
        $stmt -> bindParam(":created", $creado, PDO::PARAM_STR);
        if($stmt -> execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar() -> errorInfo());
        }
        $stmt -> close();
        $stmt = null;
    }
    static public function mdlRegistros($tabla){
        $stmt = Conexion::conectar() -> prepare("SELECT *, DATE_FORMAT(created, '%d/%m/%Y') AS fecha FROM $tabla ORDER BY id DESC");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
        $stmt = null;
    }
    static public function mdlConsulta($tabla, $item, $valor){
        $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla WHERE $item = :$item");
        $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetch();
        $stmt -> close();
        $stmt = null;
    }
    static public function mdlActualizar($tabla,$datos,$id){
        $modificado = date("Y-m-d H:i:s");
        $stmt = Conexion::conectar() -> prepare("UPDATE $tabla 
        SET first_name = :first_name, last_name = :last_name, email = :email, password = :password, phone = :phone, modified = :modified WHERE id = $id");

        $stmt -> bindParam(":first_name", $datos["first_name"], PDO::PARAM_STR);
        $stmt -> bindParam(":last_name", $datos["last_name"], PDO::PARAM_STR);
        $stmt -> bindParam(":email", $datos["email"], PDO::PARAM_STR);
        $stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
        $stmt -> bindParam(":phone", $datos["phone"], PDO::PARAM_STR);
        $stmt -> bindParam(":modified", $modificado, PDO::PARAM_STR);
        //$stmt -> bindParam(":".$id, $valor, PDO::PARAM_STR);
        if($stmt -> execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar() -> errorInfo());
        }
        $stmt -> close();
        $stmt = null;
    }
    static public function mdlEliminar($tabla, $id){
        $stmt = Conexion::conectar() -> prepare("DELETE FROM $tabla WHERE id = :id");
        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);
        if($stmt -> execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar() -> errorInfo());
        }
        $stmt -> close();
        $stmt = null;
    }
}
