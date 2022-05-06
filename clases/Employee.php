<?php

    class Employee{

        private $employeeNumber;
        private $lastName;
        private $firstName;
        private $extension;
        private $email;
        private $officeCode;
        private $reportsTo;
        private $jobTitle;

        function __construct($employeeNumber,$lastName,$firstName,$extension,$email,$officeCode,$reportsTo,$jobTitle)
        {
            $this->employeeNumber=$employeeNumber;
            $this->lastName=$lastName;
            $this->firstName=$firstName;
            $this->extension=$extension;
            $this->email=$email;
            $this->officeCode=$officeCode;
            $this->reportsTo=$reportsTo;
            $this->jobTitle=$jobTitle;
        }


        /**
         * Resuelva el nombre de la Oficina asociada a un empleado
         * @param {integer} $codeNumber Código de empleado
         * @return {string} Nombre de la Oficina
         */
        function getOfficeCodeName($codeNumber){
            if ($codeNumber==1) {
                return "San Francisco";
            }
            else if ($codeNumber==2) {
                return "Boston";
            }
            else if ($codeNumber==3) {
                return "NYC";
            }
            else if ($codeNumber==4) {
                return "Paris";
            }
            else if ($codeNumber==5) {
                return "Tokyo";
            }
            else if ($codeNumber==6) {
                return "Sydney";
            }
            else if ($codeNumber==7) {
                return "London";
            }
        }

        /**
         * Resuelva la categoría del jefe asociado a un empleado
         * @param {integer} $codeReports Código de Jefe
         * @return {string} Categoría de Jefe
         */
        function getReportsToName($codeReports){
            if (is_null($codeReports)) {
                return "President";
            }
            else if ($codeReports==1002 || $codeReports=="1002") {
                return "VP Sales";
            }
            else if ($codeReports==1056) {
                return "VP Marketing";
            }
            else if ($codeReports==1143) {
                return "Sales Manager (APAC)";
            }
            else if ($codeReports==1102) {
                return "Sales Rep";
            }
            else if ($codeReports==1088) {
                return "Sales Rep";
            }
            else if ($codeReports==1056) {
                return "Sales Rep";
            }
            else if ($codeReports==1621) {
                return "Sales Rep";
            }
            else if ($codeReports==1102) {
                return "Sales Rep";
            }
        }

        /* GETTERS */
        public function getEmployeeNumber()
        {
                return $this->employeeNumber;
        }

        public function getLastName()
        {
                return $this->lastName;
        }

        public function getFirstName()
        {
                return $this->firstName;
        }

        public function getExtension()
        {
                return $this->extension;
        }

        public function getEmail()
        {
                return $this->email;
        }

        public function getOfficeCode()
        {
                return $this->officeCode;
        }

        public function getReportsTo()
        {
                return $this->reportsTo;
        }

        public function getJobTitle()
        {
                return $this->jobTitle;
        }
        /* FIN GETTERS */

        /* SETTERS */
        public function setEmployeeNumber($employeeNumber)
        {
                $this->employeeNumber = $employeeNumber;
        }

        public function setLastName($lastName)
        {
                $this->lastName = $lastName;
        }

        public function setFirstName($firstName)
        {
                $this->firstName = $firstName;
        }
 
        public function setExtension($extension)
        {
                $this->extension = $extension;
        }   

        public function setEmail($email)
        {
                $this->email = $email;
        }

        public function setOfficeCode($officeCode)
        {
                $this->officeCode = $officeCode;
        }

        public function setReportsTo($reportsTo)
        {
                $this->reportsTo = $reportsTo;
        }

        public function setJobTitle($jobTitle)
        {
                $this->jobTitle = $jobTitle;
        }
        /* FIN SETTERS */
    }