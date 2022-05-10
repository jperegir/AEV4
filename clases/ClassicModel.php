<?php
//require_once("../autoload.php");
require_once("Conection.php");
require_once("Office.php");
require_once("Employee.php");

class ClassicModel extends Conection
{
    public $employees = [];
    public $offices = [];
    /* private $employeeNumber = [];
    private $data = []; */

    function __construct()
    {
        parent::__construct();
    }


    function countEmployees(){
        $res = 0;
        try {
            $sql = "SELECT COUNT(*) FROM employees";
            $sql = "SELECT COUNT(*) FROM employees";
            $stmt = $this->conexion->query($sql);
            $res = $stmt->fetchColumn();
        } catch (Exception | PDOException $e) {
            echo 'Fallo el ejecutar la consulta: ' . $e->getMessage();
        }
        return $res;
    }


    /**
     * Guarda toda la información de la tabla "employees" en formato array de objetos de tipo "Employee"
     */
    function getAllEmployees($comienzo, $longitud)
    {
        try {
            // $consulta = "SELECT * FROM employees order by 4 desc";
            $consulta = "SELECT * FROM employees LIMIT $comienzo,$longitud";
            $resultado = $this->conexion->query($consulta);
            if (!$resultado) {
                print "<p class=\"aviso\">Error en la consulta. SQLSTATE[{$this->conexion->errorCode()}]: {$this->conexion->errorInfo()[2]}</p>\n";
            } else {
                $registros = $resultado->fetchAll(PDO::FETCH_ASSOC);
                foreach ($registros as $employees) {
                    $this->setEmployees(new Employee(
                        intval($employees['employeeNumber']),
                        $employees['lastName'],
                        $employees["firstName"],
                        $employees["extension"],
                        $employees["email"],
                        $employees["officeCode"],
                        $employees['reportsTo'],
                        $employees['jobTitle']
                    ));
                }
            }
        } catch (Exception | PDOException $e) {
            echo 'Fallo el ejecutar la consulta: ' . $e->getMessage();
        }
    }

    /**
     * Devuelve un objeto de tipo "Employee", con los datos coincidentes del número de empleado pasado como argumento
     * @param {integaer} $employeeNumber ID único de empleado
     * @return {object} Employee con datos si el empleado existe en la BBDD o un empleado vacío en caso contrario 
     */
    function getEmployee($employeeNumber)
    {
        try {
            $sqlEmployee = "SELECT * FROM employees WHERE employeeNumber=:id";
            $stmtEmployee = $this->conexion->prepare($sqlEmployee);
            $stmtEmployee->bindParam(':id', $employeeNumber);
            if ($stmtEmployee->execute() && $stmtEmployee->rowCount() > 0) {
                $empleado = $stmtEmployee->fetch(PDO::FETCH_ASSOC);
                return new Employee(
                    $empleado["employeeNumber"],
                    $empleado["lastName"],
                    $empleado["firstName"],
                    $empleado["extension"],
                    $empleado["email"],
                    $empleado["officeCode"],
                    $empleado["reportsTo"],
                    $empleado["jobTitle"],
                );
            }
        } catch (Exception | PDOException $e) {
            echo 'Falló la consulta: ' . $e->getMessage();
            return new Employee(null, null, null, null, null, null, null, null);
        }
    }

    /**
     * Guarda toda la información de la tabla "offices" en formato array de objetos de tipo "Office"
     */
    function getAllOffices()
    {
        try {
            $consulta = "SELECT * FROM offices order by 4 desc";
            $stmt = $this->conexion->query($consulta);
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultado as $office) {
                $off = new Office($office["officeCode"], $office["city"], $office["phone"], $office["addressLine1"], $office["addressLine2"], $office['state'], $office['country'], $office['postalCode'], $office['territory']);
                $this->setOffices($off);
            }
        } catch (Exception | PDOException $e) {
            echo 'Error en la consulta: ' . $e->getMessage();
        }
    }

    /**
     * Obtiene la ciudad a la que pertenece una oficina a partir de su id numérico
     * @param {string} ID conformato numérico de una oficina
     * @return {string} Ciudad a la que pertenece una oficina seún su ID
     */
    function getEmployeeOffice($officeId)
    {
        try {
            $city = 'unknown';
            $consulta = "SELECT city FROM offices WHERE officeCode = $officeId";
            $stmt = $this->conexion->query($consulta);
            if (!$stmt) {
                print "<p class=\"aviso\">Error en la consulta. SQLSTATE[{$this->conexion->errorCode()}]: {$this->conexion->errorInfo()[2]}</p>\n";
            } else {
                $city = $stmt->fetch(PDO::FETCH_ASSOC)['city'];
            }
        } catch (Exception | PDOException $e) {
            echo 'Error en la consulta: ' . $e->getMessage();
        }
        return $city;
    }

    /* GETTERS */
    function getEmployees()
    {
        return $this->employees;
    }

    function getOffices()
    {
        return $this->offices;
    }
    /* FIN GETTERS */

    /* SETTERS */
    function setEmployees($employeeObject)
    {
        array_push($this->employees, $employeeObject);
    }

    function setOffices($officeObject)
    {
        array_push($this->offices, $officeObject);
    }
    /* FIN sETTERS */

    /**
     * Inserta un nuevo registro a la tabla "employees"
     * @param {array} $data Array con los datos a insertar en la tabla employees
     */
    function insert($data)
    {
        try {
            // INICIO TRANSACCION
            $this->conexion->beginTransaction();
            // CONSULTA 1
            $consulta1 = "SELECT MAX(employeeNumber)+1 AS maxEmployNumber FROM employees;";
            $resultado1 = $this->conexion->query($consulta1);
            if (!$resultado1) {
                print_r("Error al ejecutar la consulta 1");
            } else {
                $id = $resultado1->fetch(PDO::FETCH_ASSOC)["maxEmployNumber"];
                // CONSULTA 2
                $consulta2 = "INSERT INTO employees (employeeNumber,lastName, firstName, extension, email, officeCode,reportsTo, jobTitle) VALUES (:employeeNumber,:lastName,:firstName,:extension,:email,:officeCode,:reportsTo,:jobTitle)";
                $stmt = $this->conexion->prepare($consulta2);
                if (!$stmt) {
                    print_r("Error al preparar la consulta 2");
                } else {
                    $resultado2 = $stmt->execute(
                        [
                            ":employeeNumber" => $id,
                            ":lastName" => $data["lastName"],
                            ":firstName" => $data["firstName"],
                            ":extension" => $data["extension"],
                            ":email" => $data["email"],
                            ":officeCode" => $data["officeCode"],
                            ":reportsTo" => $data["reportsTo"],
                            ":jobTitle" => $data["jobTitle"]
                        ]
                    );
                    if (!$resultado2) {
                        print_r("Error al ejecutar la consulta 2");
                    } else {
                        print_r("Datos de empleado insertados corectamenteen BBDD");
                    }
                }
            }
            // FIN TRANSACCION
            $this->conexion->commit();
        } catch (Exception | PDOException $e) {
            echo 'Error en la ejecución de las consultas: ' . $e->getMessage();
            $this->conexion->rollBack();
        }
    }


    /**
     * Actualiza la información de un empleado a la tabla "employees"
     * @param {array} $data Array con los datos de actualización
     * @param {array} $employeeNumber ID del empleado al que actualizar
     */
    function update($data, $employeeNumber)
    {
        try {
            $sql = "UPDATE employees SET lastName=:lastName,firstName=:firstName,extension=:extension,email=:email,officeCode=:officeCode,reportsTo=:reportsTo,jobTitle=:jobTitle WHERE employeeNumber=:employeeNumber";
            /*
            UPDATE employees 
            SET lastName='',            // varchar
            firstName='',               // varchar
            extension='',               // varchar
            email='',                   // varchar
            officeCode='',              // varchar => No puede ser nulo y tiene que corresponderse con alguno de los valores definidos en la tabla office
            reportsTo='',               // int => Puede ser nulo
            jobTitle=''                 // varchar
            WHERE employeeNumber='';    // int
            */
            $stmt = $this->conexion->prepare($sql);
            if (!$stmt) {
                print_r("Error al preparar la consulta.");
            } else {
                $resultado = $stmt->execute(
                    [
                        ":employeeNumber" => $employeeNumber,
                        ":lastName" => $data["lastName"],
                        ":firstName" => $data["firstName"],
                        ":extension" => $data["extension"],
                        ":email" => $data["email"],
                        ":officeCode" => $data["officeCode"],
                        //":reportsTo" => $data["reportsTo"],
                        ":reportsTo" => null,
                        ":jobTitle" => $data["jobTitle"]
                    ]
                );
                if (!$resultado) {
                    print_r("Error al ejecutar la consulta.");
                } else {
                    print_r("Consulta ejecutada correctamente.");
                }
            }
        } catch (Exception | PDOException $e) {
            echo $e->getMessage();
            print "<p class=\"aviso\">No se ha podido actualizar la información del empleado!</p>\n";
        }
    }


    /**
     * Elimina un registro de la BBDD
     * @param {string} Id del empleado a eliminar
     * @return {boolean} True si se ha podido eliminar el registro o False en caso contrario
     */
    function delete($employeeNumber)
    {
        $retorno = false;
        try {
            $query = "DELETE FROM employees WHERE employeeNumber = :employeeNumber";
            $stmt = $this->conexion->prepare($query);
            if (!$stmt) {
                print_r("Error al preparar la consulta.");
            } else {
                $resultado = $stmt->execute([":employeeNumber" => $employeeNumber]);
                if (!$resultado) {
                    print_r("Error al ejecutar la consulta.");
                } else {
                    print_r("Empleado eliminado.");
                }
            }
            $retorno = true;
        } catch (Exception | PDOException $e) {
            //print "<p class=\"aviso\">No se ha podido eliminar el empleado!</p>\n";
            print "<p class=\"aviso\">Error en la consulta. SQLSTATE[{$this->conexion->errorCode()}]: {$this->conexion->errorInfo()[2]}</p>\n";
        }
        return $retorno;
    }


    /**
     * Dibuja las filas de la tabla de empleados
     */
    function drawEmployeesList($comienzo, $longitud)
    {
        $this->getAllEmployees($comienzo, $longitud);
        $output = "";
        foreach ($this->employees as $employee) {
            $officeCity = $this->getEmployeeOffice($employee->getOfficeCode());
            $output .= "<tr>";
            $output .= "    <td>" . $employee->getEmployeeNumber() . "</td>";
            $output .= "    <td>" . $employee->getFirstName() . " " . $employee->getLastName() . "</td>";
            $output .= "    <td>" . $employee->getJobTitle() . "</td>";
            $output .= "    <td>" . "BOSS" . "</td>";
            $output .= "    <td> extension: " . $employee->getExtension() . " / " . $employee->getEmail() . " / Office: " . $officeCity . "</td>";
            $output .=     "<td><a href='update.php?id=" . $employee->getEmployeeNumber() . "'><img src='img/edit_icon.png' width='25'></a></td>";
            $output .= "</tr>";
        }
        return $output;
    }

    /**
     * Genera las opciones para el select del formulario que permite al usuario elegir quien es el jefe del empleado
     * @param {string} ID del empleado
     */
    //function drawEmployeesOptions($selectedEmployee)
    function drawEmployeesOptions()
    {
        $output = "";
        try {
            $sql = "SELECT CONCAT_WS(' ', firstName, lastName) AS nombre, employeeNumber FROM employees";
            $stmt = $this->conexion->query($sql);
            if(!$stmt){
                print "<p class=\"aviso\">Error en la consulta. SQLSTATE[{$this->conexion->errorCode()}]: {$this->conexion->errorInfo()[2]}</p>\n";
            }else{
                $resultado=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($resultado) > 0){
                    //$output .= '<label for="jefes">Elige a tu encargado: </label>';
                    $output .= '<select name="jefes" id="jefes">';
                    foreach($resultado as $boss){
                        $output .= "<option value='" . $boss['employeeNumber'] . "'>" . $boss['nombre'] . "</option>";
                    }
                    $output .= '</select>';
                }
            }
        } catch (Exception | PDOException $e) {
            echo 'Error en la consulta: ' . $e->getMessage();
        }
        return $output;
    }

    /**
     * Genera las opciones para el select del formulario que permite al usuario elegir a qué oficina está adscrito
     * @param {string} ID del empleado
     */
    //function drawOfficesOptions($selectedOffice)
    function drawOfficesOptions()
    {
        $output = "";
        try {
            $sql = "SELECT * FROM offices";
            $stmt = $this->conexion->query($sql);
            if(!$stmt){
                print "<p class=\"aviso\">Error en la consulta. SQLSTATE[{$this->conexion->errorCode()}]: {$this->conexion->errorInfo()[2]}</p>\n";
            }else{
                $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($resultado) > 0){
                    $output .= '<select name="offices" id="offices">';
                    foreach ($resultado as $office) {
                        $output .= "<option value='" . $office['officeCode'] . "'>" . $office['city'] . "</option>";
                    }
                    $output .= '</select>';
                }
            }
        } catch (Exception | PDOException $e) {
            echo 'Error en la consulta: ' . $e->getMessage();
        }
        return $output;
    }
}


/* $c = new ClassicModel();
echo $c->drawOfficesOptions();
echo "<br>";
echo $c->drawEmployeesOptions(); */
