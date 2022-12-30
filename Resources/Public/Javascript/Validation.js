const defaultConfig = {
    classTo: 'form-group-custom',
    errorClass: 'has-danger',
    successClass: 'has-success',
    errorTextParent: 'form-group-custom',
    errorTextTag: 'small',
    errorTextClass: 'help-block'
};

// Demo validation From 
var demoForm = document.getElementById("demoForm");

if(demoForm){

    // Custom validation
    Pristine.addValidator("my-range", function(value, param1, param2) {
      return parseInt(param1) <= value && value <= parseInt(param2) 
    }, "The value (${0}) must be between ${1} and ${2}", 5, false);

    // create the pristine instance
    let  pristine = new Pristine(demoForm,defaultConfig);

    demoForm.addEventListener('submit', function (e) {
        e.preventDefault();
        var valid = pristine.validate();
    });
}


// Product From
var productForm = document.getElementById("newProduct");

if(productForm){
    // create the pristine instance
    let  pristineProduct = new Pristine(productForm,defaultConfig);

    productForm.addEventListener('submit', function (e) {
        e.preventDefault();
        var valid = pristineProduct.validate();
        // alert('Form is valid: ' + valid);
    });
}
