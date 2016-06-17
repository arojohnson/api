api
===

Yii very simple restful api module for Yii framework 1.1.x version.

Hi,

This is a module for providing very simple Restful API which automatically detects your existing models and finds the results.

Installation Steps

Step : 1 Copy the downloaded file into your protected/modules/ folder

Step : 2 Add the module in your config/main.php file under modules array as api.

Step : 3 Check by accessing yoursite.com/api/default/test

Note : In your request, you must specify your model name For example

//var data = {"name":"api1","phone":"234343","message":"sample message 4"}; // for POST method
        var data = {"id":"3"}; // for GET Method
        //var data = {"name":"my api success"}; // for PUT method
        //var data = {"id":"1"}; // For DELETE method
        $.ajax({
            url:"<?php echo Yii::app()->request->baseUrl; ?>/api?model=<your_module>&key=D3das==", // replace with your module 
//use the authentication key in base64 encoded format           
            data:data, //No need to add for GET and DELETE methods
            datType:'json',
            type: 'GET',
            success:function(result){
                $("#div1").html(result);
            }});
_ This is the start up version 0.1 The next version will be with more authentication and little bit tricks with your existing model for ease of accessing of database table vlaues._
