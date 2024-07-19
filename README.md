# Tools

Folgende Module beinhaltet das Tools Repository:

- __CreateProfileAssociations__ ([Dokumentation](CreateProfileAssociations))  
	Kurze Beschreibung des Moduls.

ProfileWithColors Module Description

Overview
The ProfileWithColors module for IP-Symcon allows users to create variable profiles with color associations. This module is particularly useful for visualizing data with color-coded values, enhancing the readability and interpretation of variable data. Users can define profiles for integer or float variables and customize the appearance with prefixes, suffixes, and color gradients.

Features
Profile Creation: Create new variable profiles for integer or float types.
Value Range Definition: Specify start, end, and step values for the profile.
Color Gradient: Define start and end colors to create a gradient effect for the profile values.
Prefix and Suffix: Add prefixes and suffixes to the profile values for better context and readability.
Digit Control: Set the number of decimal places for float profiles.
Profile Overwrite: Existing profiles with identical names will be overwritten.
Static Information: The module provides static information to users indicating how float values are handled when the integer profile is selected and the behavior of profile overwriting.
Form Fields
Profile Name: Name of the variable profile.
Start Value: Starting value of the profile range.
End Value: Ending value of the profile range.
Step Size: Incremental step size between start and end values.
Number of Digits: Specifies the precision (number of decimal places) for float profiles.
Start Color: Starting color of the gradient.
End Color: Ending color of the gradient.
Variable Type: Choose between integer and float profile types.
Prefix: Optional prefix for profile values.
Suffix: Optional suffix for profile values.
Create Profile Button: Initiates the profile creation process.
Static Information
Truncate Message: If the integer profile is selected, any float values entered for Start Value, End Value, and Step Size will be truncated to integers.
Overwrite Warning: Profiles with identical names will be overwritten.
Usage
The ProfileWithColors module is specifically designed to automate the process of creating predefined values for association buttons in IPS View. This tool simplifies the creation and management of variable profiles, ensuring consistency and efficiency when setting up association buttons. By automating this process, users can quickly and accurately create profiles that enhance the user experience in IPS View.

Installation and Configuration
Installation: The module can be installed via the IP-Symcon Module Store or manually by downloading from the repository.
Configuration: After installation, configure the module by entering the desired values in the form fields as described above.
Create Profile: Click the "Create Profile" button to generate the profile with the specified settings.
This module streamlines the process of creating and managing variable profiles with visual enhancements, making it easier for users to interpret and act on data.






