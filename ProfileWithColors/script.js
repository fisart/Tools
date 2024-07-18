function UpdateVisibility(variableType) {
    IPS_UpdateFormField('StartValueInt', 'visible', variableType === 'integer');
    IPS_UpdateFormField('StartValueFloat', 'visible', variableType === 'float');
    IPS_UpdateFormField('EndValueInt', 'visible', variableType === 'integer');
    IPS_UpdateFormField('EndValueFloat', 'visible', variableType === 'float');
    IPS_UpdateFormField('StepSizeInt', 'visible', variableType === 'integer');
    IPS_UpdateFormField('StepSizeFloat', 'visible', variableType === 'float');
}
