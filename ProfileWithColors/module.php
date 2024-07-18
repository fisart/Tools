<?php

class ProfileWithColors extends IPSModule {

    public function Create() {
        parent::Create();
        $this->RegisterPropertyString("ProfileName", "MyVariableProfile");
        $this->RegisterPropertyFloat("StartValue", 0.0);
        $this->RegisterPropertyFloat("EndValue", 100.0);
        $this->RegisterPropertyFloat("StepSize", 1.0);
        $this->RegisterPropertyInteger("StartColor", 0xFF0000);
        $this->RegisterPropertyInteger("EndColor", 0x0000FF);
        $this->RegisterPropertyString("VariableType", "integer");
        $this->RegisterPropertyString("Prefix", "");
        $this->RegisterPropertyString("Suffix", "");
        $this->RegisterPropertyInteger("Digits", 0); // New property for digits
    }

    public function ApplyChanges() {
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
        $prefix = $this->ReadPropertyString("Prefix");
        $suffix = $this->ReadPropertyString("Suffix");
        $digits = $this->ReadPropertyInteger("Digits"); // Read the number of digits

        // Truncate values to integers if VariableType is integer
        if ($variableType === "integer") {
            $startValue = intval($startValue);
            $endValue = intval($endValue);
            $stepSize = intval($stepSize);
            $digits = 0; // Ensure digits is 0 for integer type
        } else {
            // Limit the number of decimal places of the step size
            $stepSize = round($stepSize, $digits);
        }

        return $this->CreateAssociationProfileWithColors($profileName, $startValue, $endValue, $stepSize, $startColor, $endColor, $variableType, $prefix, $suffix, $digits);
    }

    private function CreateAssociationProfileWithColors($profileName, $startValue, $endValue, $stepSize, $startColor, $endColor, $variableType, $prefix, $suffix, $digits) {
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

        $type = $variableType === "float" ? 2 : 1; // Use 1 for integer
        if (!IPS_VariableProfileExists($profileName)) {
            IPS_CreateVariableProfile($profileName, $type);
        }

        IPS_SetVariableProfileValues($profileName, $startValue, $endValue, $stepSize);
        IPS_SetVariableProfileDigits($profileName, $digits);

        // Set the prefix and suffix for the profile
        IPS_SetVariableProfileText($profileName, $prefix, $suffix);

        $totalSteps = ($endValue - $startValue) / $stepSize;
        if ($totalSteps > 128) {
            return "Error: The total number of steps exceeds the maximum limit of 128.";
        }

        for ($i = 0; $i <= $totalSteps; $i++) {
            $value = $startValue + ($i * $stepSize);
            $value = $variableType === "float" ? round($value, $digits) : intval($value); // Ensure integer for integer type
            $fraction = $i / $totalSteps;
            $color = interpolateColor($startColor, $endColor, $fraction);
            IPS_SetVariableProfileAssociation($profileName, $value, strval($value), "", $color);
        }

        return "Profile created and associations set successfully with colors.";
    }
}
?>
