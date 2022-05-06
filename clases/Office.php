<?php

    class Office{

        private $officeCode;
        private $city;
        private $phone;
        private $addressLine1;
        private $addressLine2;
        private $state = null;
        private $country;
        private $postalCode;
        private $territory;

        function __construct($officeCode, $city, $phone, $addressLine1, $addressLine2, $state = null, $country, $postalCode, $territory)
        {
                $this->officeCode = $officeCode;
                $this->city = $city;
                $this->phone = $phone;
                $this->addressLine1 = $addressLine1;
                $this->addressLine2 = $addressLine2;
                $this->state = $state;
                $this->country = $country;
                $this->postalCode = $postalCode;
                $this->territory = $territory;
            
        }

        /* GETTERS */
        public function getOfficeCode()
        {
                return $this->officeCode;
        }

        public function getCity()
        {
                return $this->city;
        }

        public function getPhone()
        {
                return $this->phone;
        }

        public function getAddressLine2()
        {
                return $this->addressLine2;
        }

        public function getState()
        {
                return $this->state;
        }

        public function getCountry()
        {
                return $this->country;
        }

        public function getPostalCode()
        {
                return $this->postalCode;
        }

        public function getTerritory()
        {
                return $this->territory;
        }
        /* FIN GETTERS */


        /* SETTERS */
        public function setOfficeCode($officeCode)
        {
                $this->officeCode = $officeCode;
        }

        public function getAddressLine1()
        {
                return $this->addressLine1;
        }
        
        public function setCity($city)
        {
                $this->city = $city;
        }

        public function setPhone($phone)
        {
                $this->phone = $phone;
        }

        public function setAddressLine1($addressLine1)
        {
                $this->addressLine1 = $addressLine1;
        }

        public function setAddressLine2($addressLine2)
        {
                $this->addressLine2 = $addressLine2;
        }

        public function setState($state)
        {
                $this->state = $state;
        }

        public function setCountry($country)
        {
                $this->country = $country;
        }

        public function setPostalCode($postalCode)
        {
                $this->postalCode = $postalCode;
        }
 
        public function setTerritory($territory)
        {
                $this->territory = $territory;
        }
        /* FIN SETTERS */
    }

