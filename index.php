<?php

abstract class Person {
    private $name;
    private $eyeColor;
    private $hairColor;
    private $height;
    private $weight;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEyeColor($eyeColor) {
        $this->eyeColor = $eyeColor;
    }

    public function setHairColor($hairColor) {
        $this->hairColor = $hairColor;
    }

    public function setHeight($height) {
        $this->height = $height;
    }

    public function setWeight($weight) {
        $this->weight = $weight;
    }

    abstract public function determineRole();
}

class Patient extends Person {
    public function determineRole() {
        return "Patient";
    }
}

abstract class Staff extends Person {
    protected $hourlyRate;
    protected $workingHours;

    public function calculateSalary() {
        // Implementatie afhankelijk van het type medewerker
    }

    public function setHourlyRate($hourlyRate) {
        $this->hourlyRate = $hourlyRate;
    }

    public function setWorkingHours($workingHours) {
        $this->workingHours = $workingHours;
    }
}


class Doctor extends Staff {
    public function determineRole() {
        return "Doctor";
    }

    public function calculateSalary() {
        // Implementatie voor het berekenen van het salaris van een dokter
        return $this->hourlyRate * $this->workingHours;
    }
}

class Nurse extends Staff {
    public function determineRole() {
        return "Nurse";
    }

    public function calculateSalary() {
        // Implementatie voor het berekenen van het salaris van een verpleegster
        return $this->hourlyRate * $this->workingHours;
    }
}

class Appointment {
    private $doctor;
    private $patient;
    private $nurse; // Optioneel
    private $startTime;
    private $endTime;

    public function __construct($doctor, $patient, $startTime, $endTime, $nurse = null) {
        $this->doctor = $doctor;
        $this->patient = $patient;
        $this->nurse = $nurse;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public function calculateDuration() {
        // Bereken de duur van de afspraak in uren
        $start = strtotime($this->startTime);
        $end = strtotime($this->endTime);
        $duration = ($end - $start) / 3600; // Converteer naar uren
        return $duration;
    }

    public function calculateCost() {
        // Bereken de kosten van de afspraak (loon van de dokter en bonus van de verpleegster)
        $doctorSalary = $this->doctor->calculateSalary();
        $nurseBonus = ($this->nurse) ? $this->nurse->calculateSalary() : 0;
        return $doctorSalary + $nurseBonus;
    }

    public function getPatient() {
        return $this->patient;
    }

    public function getDoctor() {
        return $this->doctor;
    }

    public function getNurse() {
        return $this->nurse;
    }

    public function getStartTime() {
        return $this->startTime;
    }

    public function getEndTime() {
        return $this->endTime;
    }
}

// Definieer een concrete Patient
$patient = new Patient();
$patient->setName("John Doe");
$patient->setEyeColor("Blue");
$patient->setHairColor("Blonde");
$patient->setHeight(180);
$patient->setWeight(75);

// Definieer een concrete Doctor
$doctor = new Doctor();
$doctor->setName("Dr. Smith");
$doctor->setEyeColor("Brown");
$doctor->setHairColor("Black");
$doctor->setHeight(175);
$doctor->setWeight(70);
$doctor->setHourlyRate(50);
$doctor->setWorkingHours(8);

// Definieer een concrete Nurse
$nurse = new Nurse();
$nurse->setName("Nurse Johnson");
$nurse->setEyeColor("Green");
$nurse->setHairColor("Red");
$nurse->setHeight(160);
$nurse->setWeight(55);
$nurse->setHourlyRate(30);
$nurse->setWorkingHours(40);

// Maak een afspraak tussen de dokter, patiënt en verpleegster
$appointment = new Appointment($doctor, $patient, "2024-03-07 09:00:00", "2024-03-07 10:30:00", $nurse);

// Toon gegevens van de afspraak
echo "Appointment Details:\n";
echo "Patient: " . $appointment->getPatient()->getName() . "\n";
echo "Doctor: " . $appointment->getDoctor()->getName() . "\n";
echo "Nurse: " . (($appointment->getNurse()) ? $appointment->getNurse()->getName() : "None") . "\n";
echo "Start Time: " . $appointment->getStartTime() . "\n";
echo "End Time: " . $appointment->getEndTime() . "\n";
echo "Duration: " . $appointment->calculateDuration() . " hours\n";
echo "Cost: $" . $appointment->calculateCost() . "\n";


?>
