<?php

class ProfileWithColors extends IPSModule {

    public function Create() {
        //Never delete this line!
        parent::Create();

        // Register properties
        $this->RegisterPropertyString("ProfileName", "MyVariableProfile");
        $this->RegisterPropertyFloat("StartValue", 0);
        $this->RegisterPropertyFloat("EndValue", 100);
        $this->RegisterPropertyFloat("StepSize", 1);
        $this->RegisterPropertyInteger("StartColor", 0xFF0000); // Red
        $this->RegisterPropertyInteger("EndColor", 0x0000FF); // Blue
        $this->RegisterPropertyString("VariableType", "integer"); // Default type
    }

    public function ApplyChanges() {
        //Never delete this line!
        parent::ApplyChanges();
    }
    
    public function CreateProfileWithColors() {
        $profileName = $this->ReadPropertyString("ProfileName");
        $startValue = $this->ReadPropertyFloat("StartValue");
        $endValue = $this->ReadPropertyFloat("EndValue");
        $stepSize = $this->ReadPropertyFloat("StepSize");
        $startColor = $this->ReadPropertyInteger("StartColor");
        $endColor = $this->ReadPropertyInteger("EndColor");
        $variableType = $this->ReadPropertyString("VariableType");

        return $this->CreateAssociationProfileWithColors($profileName, $startValue, $endValue, $stepSize, $startColor, $endColor, $variableType);
    }

    private function CreateAssociationProfileWithColors($profileName, $startValue, $endValue, $stepSize, $startColor, $endColor, $variableType) {
        // Function to interpolate colors
        function interpolateColor($startColor, $endColor, $fraction) {
            $r1 = ($startColor >> 16) & 0xFF;
            $g1 = ($startColor >> 8) & 0xFF;
            $b1 = $startColor & 0xFF;

            $r2 = ($endColor >> 16) & 0xFF;
            $g2 = ($endColor >> 8) & 0xFF;
            $b2 = $endColor & 0xFF;

            $r = (int)($r1 + ($r2 - $r1) * $fraction);
            $g = (int)($g1 + ($g2 - $g1) * $fraction);
            $b = (int)($b1 + ($b2 - $b1) * $fraction);

            return ($r << 16) + ($g << 8) + $b;
        }

        // Function to calculate the number of decimal places
        function calculateDigits($stepSize) {
            $stepSizeStr = (string)$stepSize;
            $pos = strpos($stepSizeStr, '.');
            if ($pos === false) {
                return 0;
            } else {
                return strlen($stepSizeStr) - $pos - 1;
            }
        }

        // Determine the variable type
        $type = 0; // Default to integer
        if ($variableType === "float") {
            $type = 2; // 2 stands for float type
        }

        // Check if profile exists, if not, create it
        if (!IPS_VariableProfileExists($profileName)) {
            IPS_CreateVariableProfile($profileName, $type);
        }

        // Set profile values
        IPS_SetVariableProfileValues($profileName, $startValue, $endValue, $stepSize);

        // Set the number of digits
        $digits = calculateDigits($stepSize);
        IPS_SetVariableProfileDigits($profileName, $digits);

        // Calculate total steps
        $totalSteps = ($endValue - $startValue) / $stepSize;
        if ($totalSteps > 128) {
            return "Error: The total number of steps exceeds the maximum limit of 128.";
        }

        // Loop through the values and set associations with colors
        for ($i = 0; $i <= $totalSteps; $i++) {
            $value = $startValue + ($i * $stepSize);
            $value = round($value, $digits); // Ensure the value is correctly rounded
            $fraction = $i / $totalSteps;
            $color = interpolateColor($startColor, $endColor, $fraction);

            IPS_SetVariableProfileAssociation($profileName, $value, number_format($value, $digits), "", $color);
        }

        return "Profile created and associations set successfully with colors.";
    }
}

?>
