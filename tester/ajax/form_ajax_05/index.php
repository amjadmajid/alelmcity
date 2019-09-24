<?php
/* The overall idea
------------------------*/
/*
 */

?>

<!doctype html>
<html lang="en">
    <head> 
        <meta charset="set-8">
        <title> Asynchronous Button</title>

        <style>
            #result{
                display:none;
            }
        </style>

    </head>
<body>
    <div id="measurements">
        <p>Enter measurements to determine the total volume.</p>
        <form id="measurement-form" action="process-measurements.php" method="POST">
            Length:<input type="text" name="length"><br><br>
            Width:<input type="text" name="width"><br><br>
            Height:<input type="text" name="height"><br><br>

            <input id="html-submit" type="submit" value="Submit" >
            <!-- it is always better to use a button then submit field type when 
                submitting a form using Ajax -->
            <input id="ajax-submit" type="button" value="Ajax submit" >

        </form>
    </div>

    <div id="result">
        <p>Total volume is: <span id="volume"></span></p>
    </div>

</body>
<script>
var  result_div = document.getElementById("result");
var volume = document.getElementById("volume");

function postResult(value){
    volume.innerHTML = value;
    result_div.style.display = 'block';
}

function clearResult(){
    volume.innerHTML='';
    result_div.style.display = 'none';
}

function gatherFormData(form){
    var inputs = form.getElementsByTagName('input');
    var array = [];
    for(i=0; i < inputs.length; i++){
        var inputNameValue = inputs[i].name +'='+ inputs[i].value;
        array.push(inputNameValue);
    }
    return array.join('&');
}

function calculateMeasurements(){
    clearResult();

    var form = document.getElementById("measurement-form");

    var action = form.getAttribute('action');
    // gather form data:
    // 1) Using custom code
    var form_data = gatherFormData(form);
    // 2) using javaScript `FormData` object
    // var gather_data = new FomrData(form);
    //Do not set the Content-type request header when using FormData object
    //The `FormData` object is not supported by IE9 or older versions
    console.log( form_data);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', action , true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function(){
        //console.log( 'readyState:', xhr.readyState);

        if(xhr.readyState == 4 && xhr.status ==200){
            var result = xhr.responseText;
            console.log('Result: ' + result);
            postResult(result);
        }
    };
    xhr.send(form_data);
}
var button = document.getElementById("ajax-submit");
button.addEventListener("click", calculateMeasurements);
</script>
</body>
</html>

