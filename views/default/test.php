TEST 


<div id="div1">
    
</div>

<button value='Test'>TEST NOW THE API</button>

<script>
    $("button").click(function(){
        //var data = {"name":"api1","phone":"234343","message":"sample message 4"}; // for POST method
        var data = {"id":"3"}; // for GET Method
        //var data = {"name":"my api success"}; // for PUT method
        //var data = {"id":"1"}; // For DELETE method
        $.ajax({
            url:"<?php echo Yii::app()->request->baseUrl; ?>/api?model=inline",
            data:data, //No need to add for GET and DELETE methods
            datType:'json',
            type: 'GET',
            success:function(result){
                $("#div1").html(result);
            }});
    });
</script>
